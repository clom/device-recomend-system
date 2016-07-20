<html>
<?php
$title = "signup!"; 
include_once(dirname(__FILE__).'/header.html'); 
?>
    <body>
        <?php include_once(dirname(__FILE__).'/navbar.html'); ?>  
        <div class="container">
            <h1> Welcome to new member!! </h1>
            <div class="alert alert-info" role="alert">
                <p>本サービスは限りなくベータ版です.不具合によるサービス停止もございます.</p>
            </div>
            <form class="form" method="POST" action="./lib/adduser.php">
                <input class="form-control input-sm" name="uid" type="text" placeholder="Username" required><br>
                <input class="form-control input-sm" name="password" type="password" placeholder="password" required><br>
                <input class="form-control input-sm" name="ckpassword" type="password" placeholder="check password" required><br>
                <button type="submit" class="btn btn-success btn-block">SignUp!</button>
            </form>
        </div>
    </body>
</html>