<?php
    
    if(is_numeric($_POST["n1"]) && is_numeric($_POST["n2"]))
        echo "Mutiplicação: " . ($_POST["n1"] * $_POST["n2"]); 
    else
        echo "Erro no cálculo, tente novamente";

?>