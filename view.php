<html>
<?php
$title = "Device View"; 
include_once(dirname(__FILE__).'/header.html');
require_once(dirname(__FILE__).'/selecter.php'); 
$spec = 0;
$design = 0;
$price = 0;
if(!empty($_POST['spec']) && !empty($_POST['design']) && !empty($_POST['price'])){
    $spec = $_POST['spec'];
    $design = $_POST['design'];
    $price = $_POST['price'];
}

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
                        <br>
                        <form class="form-inline" method="POST" action="./lib/eval.php">
                            <div class="form-group">
                                <label>Spec</label>
                                <select class="form-control" name="spec" style="margin: 0 5px;">
                                    <?php selected_generator($spec); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Design</label>
                                <select class="form-control" name="design" style="margin: 0 5px;">
                                    <?php selected_generator($design); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <select class="form-control" name="price" style="margin: 0 5px;">
                                    <?php selected_generator($price); ?>
                                </select>
                            </div>
                            <br><br>                            
                            <button type="submit" class="btn btn-primary btn-large btn-block">Eval</button>
                        </form>
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