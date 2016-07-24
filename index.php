<html>
<?php
$title = "Device Recommend Service"; 
include_once(dirname(__FILE__).'/header.html');
require_once(dirname(__FILE__).'/lib/action.php');
require_once(dirname(__FILE__).'/conf.php'); 

if(login_check()){
    $result = collaborative_recommend($_SESSION['account']);
    $count = count($result);
    if($count < $max_recommend){
        $mx_recommend = $count;
    }
    else{
        $mx_recommend = $max_recommend;
    }
}


?>
    <body>
        <?php include_once(dirname(__FILE__).'/navbar.html'); ?>  
        <div class="container">
            <h1> Welcome to Device Recommend Service! </h1>
            <div class="alert alert-info" role="alert">
                <p>本サービスは限りなくベータ版です.不具合によるサービス停止もございます.</p>
            </div>
            <button type="button" class="btn btn-lg btn-success btn-block" onclick="location.href='./search.php'">Let's Start!</button><br>
            すべてのデバイスリストを表示するなら <b>→</b> <button type="button" class="btn btn-lg btn-warning" onclick="location.href='./list.php'">Device List</button>

            <?php if(login_check()){ ?>
            <hr>
            <h4>あなたが評価しているデバイスに似た評価をしたユーザは次のデバイスを評価しています。</h4>
            <table class="table table-bordered">
                    <thead>
                        <th>Device name</th>
                        <th>Rank</th>
                    </thead>
                    <tbody>
                        <?php
                            for ($i = 0; $i < $mx_recommend; $i++){
                                $num = $i + 1;
                                //  $result[$i]['similarity'] はピアソン相関を用いた類似度
                                //  $num は順位
                                echo "<tr><td><a href='./view.php?devid=".getDevice_ID($result[$i]['device'])."'>".$result[$i]['device']."</a></td><td>".$num."</td></tr>";
                            }
                        ?>
                    </tbody>
            <?php } ?>

        </div>
    </body>
</html>
