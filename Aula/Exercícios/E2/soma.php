<?php
    
    if(is_numeric($_GET["n1"]) && is_numeric($_GET["n2"]))
        echo "Soma: " . ($_GET["n1"] + $_GET["n2"]); 
    else
        echo "Erro no cálculo, tente novamente";

?>