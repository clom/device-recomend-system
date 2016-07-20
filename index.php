<html>
<?php
$title = "Device Recommend Service"; 
include_once(dirname(__FILE__).'/header.html'); 
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
        </div>
    </body>
</html>
