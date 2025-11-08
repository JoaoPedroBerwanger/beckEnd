<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    function calcularX($a, $b){
        
        return $a + $b;
    }
        
    $a = 1;
    $b = 5;

    $linha = "<br>";
    
    echo calcularX($a, $b);

    echo $linha;
    echo $linha;

    $cores = array("vermelho", "azul", "rosa","amarelo", "verde", "preto", "branco");
    $v = 0;

    foreach($cores as $cor){
        
        $v++;

        switch ($cor){

        case "verde":
            echo "$cor $v <br>";
        break;

        case "preto":
            echo "$cor $v <br>";
        break;

        case "rosa":
            echo "não encontrado $v <br>";
        break;
        
    }}

    echo $linha;

    function addNumeros(int $a, int $b){
        return $a + $b;
    }

    echo addNumeros(5, 20);

    $numeros = array(1,2,3,4,5);
    sort($numeros);

    for($i = 0; $i < count($numeros); $i++)
    {echo $numeros[$i];}
    
    
        /*do{
            echo $i;a
            $i++;
        } while ($i < 6);

        $x = 1;

        while($x <= 10)
        {
            echo $x++;
        };*/

        /*for ($x = 1; $x <= 10; $x++){
            echo "O numero é: $x <br>";
        }*/
    ?>
</body>

</html>