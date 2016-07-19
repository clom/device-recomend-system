<html>
<?php
$title = "Device Search"; 
include_once(dirname(__FILE__).'/header.html'); 
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
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <br>
                    <label>Design</label>
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <br>
                    <label>Price</label>
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
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
                        <th>Spec Avg.</th>
                        <th>Design Avg.</th>
                        <th>Price Avg.</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
