<?php

    $palavra = strtolower($_POST["palavra"]);
    $vogais = ["a","e","i","o","u"];
    $qtdVogais = 0;
    
    for($i = 0; $i < strlen($palavra); $i++) {
        if(in_array($palavra[$i], $vogais))
            $qtdVogais++;    
    }

    echo "A quantidade de vogais na palavra: " . $palavra . ", é igual a " . $qtdVogais;
?>