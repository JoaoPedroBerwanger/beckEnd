<?php 

    /*°F = (°C x 1,8) + 32.*/

    if(!empty($_GET["celcius"]))
    {
        echo "Temperatura em Celcius: " . $_GET["celcius"] . "°C <br>"; 
        echo "Temperatura em Fahrenheit: " . (($_GET["celcius"]*1.8) + 32) . "°F"; 
    } 
    else 
        echo "Temperatura não informada.";
?>