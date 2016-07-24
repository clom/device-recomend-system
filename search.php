<html>
<?php
$title = "Device Search"; 
include_once(dirname(__FILE__).'/header.html');
require_once(dirname(__FILE__).'/selecter.php');
require_once(dirname(__FILE__).'/lib/action.php');
require_once(dirname(__FILE__).'/conf.php');  
$spec = 0;
$design = 0;
$price = 0;
$result = array();
$flag = false;

if(!empty($_POST['spec']) && !empty($_POST['design']) && !empty($_POST['price'])){
    $spec = $_POST['spec'];
    $design = $_POST['design'];
    $price = $_POST['price'];

    // contents base filltering
    $input = array('spec' => $spec, 'design' => $design, 'price' => $price);
    $result = contents_recommend($input);
    $flag = true;
}

?>
    <body>
        <?php include_once(dirname(__FILE__).'/navbar.html'); ?>  
        <div class="container">
            <div class="alert alert-info" role="alert">
                <p>本サービスは限りなくベータ版です.不具合によるサービス停止もございます.</p>
            </div>
            <hr>
            <h2> Recommend Your Device </h2>
            <div class="col-md-4">
                <form method="POST" action="search.php">
                    <label>Spec</label>
                    <select class="form-control" name="spec">
                        <?php selected_generator($spec); ?>
                    </select>
                    <br>
                    <label>Design</label>
                    <select class="form-control" name="design">
                        <?php selected_generator($design); ?>
                    </select>
                    <br>
                    <label>Price</label>
                    <select class="form-control" name="price">
                        <?php selected_generator($price); ?>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-primary btn-large btn-block">Search</button>
                </form>
            </div>
            <div class="col-md-8">
                <h2>推薦結果</h2>
                <table class="table table-bordered">
                    <thead>
                        <th>Device name</th>
                        <th>Rank</th>
                    </thead>
                    <tbody>
                        <?php
                        if($flag){
                            for ($i = 0; $i < $max_recommend; $i++){
                                $num = $i + 1;
                                //  $result[$i]['similarity'] はコサイン類似度
                                //  $num は順位
                                echo "<tr><td><a href='./view.php?devid=".$result[$i]['dev_id']."'>".$result[$i]['device']."</a></td><td>".$num."</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
