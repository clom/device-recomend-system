 <?php
    session_start();
    function login_check(){
        if(empty($_SESSION['account'])){
            return false;
        } else{
            return true;
        }
    }

    function search_device($id){
         // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
   	    if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
        else{
	        $sql = "select * from device where ID=".$id;
	        $result = $link->query($sql);
            $res = $result->fetchArray(SQLITE3_ASSOC);
            $link->close();
            return $res;
        }
    }
    
    // contents base filltering. start
    //array {spec,design,price}
    function contents_recommend(array $input_val){
        $recommend = array();
        $input_sum = 0;

        // input sum 
        foreach (array_keys($input_val) as $note){
            $input_sum += $input_val[$note] *  $input_val[$note];
        }

        // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
   	    if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
        else{
	        $sql = "select Dev_ID, name, avg(Spec), avg(Design), avg(Price) from device, eval where device.ID = eval.Dev_ID group by name";
	        $result = $link->query($sql);
            while($res = $result->fetchArray(SQLITE3_ASSOC)){
                // init 
                $device_val = array('spec' => $res['avg(Spec)'] , 'design' => $res['avg(Design)'], 'price' => $res['avg(Price)']);
                $denominator = 0;
                $molecule = 0;
                $device_sum = 0;

                // molecule 
                foreach (array_keys($input_val) as $note1) {
                    foreach (array_keys($device_val) as $note2) {
                        if($note1 === $note2){
                            $molecule += $device_val[$note1] * $input_val[$note2];  
                        }
                    }
                }

                // denominator exclude $input_sum
                foreach (array_keys($device_val) as $note){
                    $device_sum += $device_val[$note] *  $device_val[$note];
                }

                $denominator = sqrt($input_sum) * sqrt($device_sum);

                $num = $molecule / $denominator;
                $device_result = array('dev_id' => $res['Dev_ID'], 'device' => $res['name'] , 'similarity' => $num);
                array_push($recommend, $device_result);
            }
        // sort
        array_multisort(array_column($recommend, 'similarity'), SORT_DESC, $recommend);
        // sqlite close;
        $link->close();

        return $recommend;
        }

    }
    // ended

    // Collaborative Filtering. start
    // array {userid, evalAVG,}
    function collaborative_recommend($user){
        $recommend = array();
        $useravg = array();
        $total = array();
        $sim_sum = array();

        // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
   	    if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
        else{
            //device array
            $sql = "select name from device";
	        $result = $link->query($sql);
            while($res = $result->fetchArray(SQLITE3_ASSOC)){
                $total = array_merge($total, array($res['name'] => 0));
                $sim_sum = array_merge($sim_sum, array($res['name'] => 0));
            }
             // array {userid => array(device => avg, ......)}
	        $sql = "select ID, Account_name from auth";
	        $u_result = $link->query($sql);
            while($res = $u_result->fetchArray(SQLITE3_ASSOC)){
                $accountid = $res['ID'];
                $sql = "select Dev_ID, name, Spec, Design, Price from device, eval where device.ID = eval.Dev_ID and Account_ID = ".$accountid;
	            $d_result = $link->query($sql);
                $device = array();
                while ($ures = $d_result->fetchArray(SQLITE3_ASSOC)) {
                    $device_name = $ures['name'];
                    $avg = ($ures['Spec'] + $ures['Design'] + $ures['Price']) / 3;
                    $device = array_merge($device, array($device_name => $avg));
                }
                $useravg = array_merge($useravg, array($res['Account_name'] => $device));
            }


        }
        foreach ($useravg as $person => $value) {
            if($user === $person){
            }
            else{
                $peason_s = person_sim($useravg, $user, $person);
                if($peason_s >= 0){
                    foreach ($value as $device_n => $value) {
                        if(!array_key_exists($device_n, $useravg[$user]) || $useravg[$user][$device_n] == 0){
                            // score * peason_sim 
                            $total[$device_n] += $useravg[$person][$device_n] * $peason_s;
                            $sim_sum[$device_n] += $peason_s;
                        }
                    }
                }
            }
        }
        $i = 0;
        foreach ($total as $item => $value) {
            if($sim_sum[$item] != 0){
                $score = $value / $sim_sum[$item];
                $dev_score = array('device' => $item, 'similarity' => $score);
                $recommend = array_merge($recommend, array($i => $dev_score));
            }
            $i++;
        }

        array_multisort(array_column($recommend, 'similarity'), SORT_DESC, $recommend);

        $link->close();
        return $recommend;
    }

    // $prefs: 対象データ
    // $person1, $person2: 人
    function person_sim($prefs, $person1, $person2){
        $sim = array();
        foreach ($prefs[$person1] as $item => $value) {
            if(array_key_exists($item, $prefs[$person2])){
                $sim[$item] = 1;
            }
        }

        if(count($sim) === 0){
            return 0.0;
        }

        // sum
        $psum1 = 0.0;
        $psum2 = 0.0;

        // sqrt sum 
        $psumsq1 = 0.0;
        $psumsq2 = 0.0;
    
        // multi sum
        $psum = 0.0;
    
        // culcurator
        foreach ($sim as $item => $value) {
            $psum1 += $prefs[$person1][$item];
            $psum2 += $prefs[$person2][$item];
            $psumsq1 += $prefs[$person1][$item] * $prefs[$person1][$item];
            $psumsq2 += $prefs[$person2][$item] * $prefs[$person2][$item];
            $psum += $prefs[$person1][$item] * $prefs[$person2][$item];
        }

        $molecule = $psum - ($psum1 * $psum2 / count($sim)) ;
        $denominator = sqrt(($psumsq1 - ($psum1 * $psum1) / count($sim))* ($psumsq2 - ($psum2 * $psum2) / count($sim)));
        if($denominator === 0.0){
            return 0.0;
        }
        else{
            return $molecule / $denominator;
        }
    }

    // ended

    function all_device_table(){
         // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
   	    if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
        else{
	        $sql = "select * from device";
	        $result = $link->query($sql);
            while($res = $result->fetchArray(SQLITE3_ASSOC)){
                echo "<tr><td><a href='/view.php?devid=".$res['ID']."'>".$res['name']."</a></td><td>".$res['maker']."</td></tr>";
            }
        $link->close();
        }
    }

    function all_eval_usertable($devid){
        // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
   	    if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
        else{
	        $sql = "select Account_name, Spec, Design, Price from auth, eval where eval.Account_ID = auth.ID and Dev_ID = ".$devid;
	        $result = $link->query($sql);
            while($res = $result->fetchArray(SQLITE3_ASSOC)){
                echo "<tr><td>".$res['Account_name']."</td><td>".$res['Spec']."</td><td>".$res['Design']."</td><td>".$res['Price']."</td></tr>";
            }
        $link->close();
        }
    }

    function getDevice_ID($dev_name){
         // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
   	    if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
        else{
	        $sql = "select * from device where name ='".$dev_name."'";
	        $result = $link->query($sql);
            $res = $result->fetchArray(SQLITE3_ASSOC);
            return $res['ID']; 
        }
        $link->close();
        return 0;
    }

    session_write_close();
?>