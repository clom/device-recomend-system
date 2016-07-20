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

    session_write_close();
?>