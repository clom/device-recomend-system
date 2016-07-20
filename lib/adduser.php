<?php
    session_start();
    require_once(dirname(__FILE__)."/../conf.php");
    
    // POST info
    $id = htmlspecialchars($_POST['uid']);
    $pass = sha1($_POST['password']);
    $passc = sha1($_POST['ckpassword']);

    

    if($pass == $passc){
        // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
        if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
	    else{
		    $sql = "select count(*) from auth where Account_name = '".$id."'";
		    $result = $link->query($sql);
            $res = $result->fetchArray(SQLITE3_ASSOC);
            if($res['count(*)'] == 0){
                $sql = "insert into auth (Account_name, Pass_word) values ('".$id."','".$pass."')";
	            $result = $link->exec($sql);
            }
        }
        $link->close();
    }
    // redirect path
    header("Location: /");

?>