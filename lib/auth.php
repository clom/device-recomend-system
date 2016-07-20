<?php
    session_start();
    require_once(dirname(__FILE__)."/../conf.php");
    
    // POST info
    $id = $_POST['uid'];
    $pass = sha1($_POST['password']);
    $preturn = $_POST['returnpath'];

    // sqlite connect
    $link = new SQLite3(dirname(__FILE__) . "/../main.db");
    if (!$link) {
        die('接続失敗です。'.$sqliteerror);
    }
	else{
		$sql = "select Account_name, Pass_word from auth where Account_name = '".$id."'";
		$result = $link->query($sql);
        $res = $result->fetchArray(SQLITE3_ASSOC);
        if($pass == $res['Pass_word']){
            $_SESSION['account'] = $id;
        }
    }
    $link->close();

    // redirect path
    header("Location:".$preturn);
?>