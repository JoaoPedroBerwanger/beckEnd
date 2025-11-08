<?php

    $idade = $_POST["idade"];
    
    if ($idade < 18)
        echo "Menor de idade";
    else 
        echo "Maior de idade";
    
?>