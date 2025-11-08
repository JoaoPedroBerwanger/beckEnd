<?php 

    echo "Par ou Impar? <br>";
    $text = "O valor " . $_GET["num"] . " é ";


    if(!empty($_GET["num"]))
    {
        if($_GET["num"] % 2 == 0)
            echo $text . "par.";
        else
            echo $text . "impar.";
    } else { echo "Valor não informado";}
?>