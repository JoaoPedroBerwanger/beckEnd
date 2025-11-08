<?php

    $a = $_POST["altura"];
    $p = $_POST["peso"];
    $imc = ($p / ($a * $a));
    
    switch (true) {

        case ($imc < 18.50):
            echo "IMC de: " . $imc . " - Classificação de Magreza.";
        break;
        
        case ($imc >= 18.50 && $imc < 25):
            echo "IMC de: " . $imc . " - Classificação de Normal.";
        break;
        
        case ($imc >= 25 && $imc < 30):
            echo "IMC de: " . $imc . " - Classificação de Sobrepeso.";
        break;

        case ($imc >= 30 && $imc < 35):
            echo "IMC de: " . $imc . " - Classificação de Obesidade Grau I.";
        break;

        case ($imc >= 35 && $imc <= 40):
            echo "IMC de: " . $imc . " - Classificação de Obesidade Grau II.";
        break;

        case ($imc > 40):
            echo "IMC de: " . $imc . " - Classificação de Obesidade Grau III.";
        break;
        
        default:
        echo "Não foi possível realizar o cálculo, dados informador incorretamente.";
        
    }
?>