<html>
<?php
$title = "signup!"; 
require_once(dirname(__FILE__)."/lib/action.php");
if(!login_check()){
    header("Location: /");
}

include_once(dirname(__FILE__).'/header.html');
?>
    <body>
        <?php include_once(dirname(__FILE__).'/navbar.html'); ?>  
        <div class="container">
            <h1>Add new Device!! </h1>
            <div class="alert alert-info" role="alert">
                <p>本サービスは限りなくベータ版です.不具合によるサービス停止もございます.</p>
            </div>
            <form class="form" method="POST" action="./lib/newdev.php">
                <input class="form-control input-sm" name="device" type="text" placeholder="Device Name" required><br>
                <input class="form-control input-sm" name="maker" type="text" placeholder="Manufacturer" required><br>
                <button type="submit" class="btn btn-success btn-block">Add!</button>
            </form>
        </div>
    </body>
</html>