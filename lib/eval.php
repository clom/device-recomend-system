<?php
    session_start();
    require_once(dirname(__FILE__)."/../conf.php");
    
    // POST info
    $spec = $_POST['spec'];
    $design = $_POST['design'];
    $price = $_POST['price'];
    $device = $_POST['devid'];

    

        // sqlite connect
        $link = new SQLite3(dirname(__FILE__) . "/../main.db");
        if (!$link) {
            die('接続失敗です。'.$sqliteerror);
        }
	    else{
            $sql = "select ID from auth where Account_name = '".$_SESSION['account']."'";
		    $result = $link->query($sql);
            $res = $result->fetchArray(SQLITE3_ASSOC);
            $account_id = $res['ID'];
		    $sql = "select count(*) from eval where Account_ID = '".$account_id."' and Dev_ID=".$device;
		    $result = $link->query($sql);
            $res = $result->fetchArray(SQLITE3_ASSOC);
            if($res['count(*)'] == 0){
                $sql = "insert into eval (Dev_ID, Account_ID, Spec, Design, Price) values ('".$device."','".$account_id."','".$spec."','".$design."','".$price."')";
	            $result = $link->exec($sql);
            } else {
                $sql = "update eval set Spec = '".$spec."', Design = '".$design."', Price = '".$price."' where Dev_ID='".$device."' and Account_ID = '".$account_id."'";
	            $result = $link->exec($sql);
            }
        }
        $link->close();

    // redirect path
    header("Location: /view.php?devid=".$device);

?>