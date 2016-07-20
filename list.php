<?php
$title = "Device ALL List"; 
include_once(dirname(__FILE__).'/header.html');
require_once(dirname(__FILE__).'/selecter.php'); 

?>
    <body>
        <?php include_once(dirname(__FILE__).'/navbar.html'); ?>  
        <div class="container">
            <div class="alert alert-info" role="alert">
                <p>本サービスは限りなくベータ版です.不具合によるサービス停止もございます.</p>
            </div>
            <hr>
            <h2> ALL Device List </h2>
            <div class="col-md-1">
            </div>
            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead>
                        <th>Device name</th>
                        <th>Spec Avg.</th>
                        <th>Design Avg.</th>
                        <th>Price Avg.</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1">
            </div>
        </div>
    </body>
</html>
