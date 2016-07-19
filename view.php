<html>
<?php
$title = "Device View"; 
include_once(dirname(__FILE__).'/header.html'); 
?>
    <body>
        <?php include_once(dirname(__FILE__).'/navbar.html'); ?>  
        <div class="container">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <p> Device Name </p>
                    </div>
                    <div class="panel-body">
                        <p> Your Eval Rating </p>
                    </div>
                </div>
                <h1>ALL User Eval</h1>
                <table class="table table-bordered">
                    <thead>
                        <th>Username</th>
                        <th>Spec</th>
                        <th>Design</th>
                        <th>Price</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h1>Similar User Recommend Device</h1>
            </div>
        </div>
    </body>
</html>