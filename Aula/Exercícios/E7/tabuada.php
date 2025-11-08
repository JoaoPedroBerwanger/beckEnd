<?php 

    $num = $_GET["num"];
    echo "Tabuada do " . $num . ":<br>";
    
    for($i = 1; $i < 11; $i++)
    {
        echo $i . " x " . $num . " = " . ($i*$num) . "<br>";
    }
?>