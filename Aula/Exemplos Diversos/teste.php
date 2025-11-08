<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    echo "Meu primeiro php" . "<br>";
    $nome = "João Pedro";
    Echo "Meu nome é ". $nome;

    // Não precisa declarar o formato da variável, a informação que chega é o suficiente 
    
    $x="6";
    $z="4";
    
    echo $x + $z;
    
    $time = date (format: "H");
    
    If ($time < "20"){
        echo "<br>"."Tenha um bom dia". "<br>";
    }else {
        echo "Tenha uma boa noite";
    };
    
    echo date(format: "l") . "<br>";
    echo date (format: 'l Js \of  y h:is:s A') . "<br>";
    $cor = "Azul";
    switch($cor){
        case "Azul":
            echo "Sua cor favorita é $cor";
            break;
    }
    ?>
    
</body>
</html>