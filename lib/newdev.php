<?php
    session_start();
    require_once(dirname(__FILE__)."/../conf.php");
    
    // POST info
    $device = htmlspecialchars($_POST['device']);
    $maker = htmlspecialchars($_POST['maker']);

    

        // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
        if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
	    else{
		    $sql = "select count(*) from device where name = '".$device."'";
		    $result = $link->query($sql);
            $res = $result->fetchArray(SQLITE3_ASSOC);
            if($res['count(*)'] == 0){
                $sql = "insert into device (name, maker) values ('".$device."','".$maker."')";
	            $result = $link->exec($sql);
		        $sql = "select * from device where name = '".$device."'";
		        $result = $link->query($sql);                
            }
             $res = $result->fetchArray(SQLITE3_ASSOC);
             $numb = $res['ID'];

        }
        $link->close();

    // redirect path
    header("Location: /view.php?devid=".$numb);

?>