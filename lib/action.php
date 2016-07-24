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
    function collaborative_recommend(array $user){

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

    session_write_close();
?>