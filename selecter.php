<?php
require(dirname(__FILE__).'/conf.php'); 

function selected_generator($target){
    global $maxselect;
    for($i = 1; $i <= $maxselect ; $i++){
        if ($i == $target) {
            echo "<option value='".$i."' selected>".$i."</option>";
        }
        else {
            echo "<option>".$i."</option>";
        }
    }
}


?>