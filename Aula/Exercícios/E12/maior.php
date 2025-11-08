<?php
    
    $n1 = $_GET["n1"];
    $n2 = $_GET["n2"];
    
    if($n1 == $n2)
        echo "iguals";
    if($n1 < $n2)
        echo $n2;
    if($n1 > $n2)
        echo $n1;

?>