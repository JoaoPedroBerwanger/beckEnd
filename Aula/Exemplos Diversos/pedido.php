<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    $cafe = $_POST["cafe"];
    $copo = $_POST["copo"];

    echo "Seu pedido:";
    echo "<br>Opção Selecionada: " . $_POST["cafe"];
    echo "<br>Tamanho Selecionado: " . $copo;

    if ($cafe == "Preto") {   
    switch($copo){
        case "150 ML":
            echo "<br>Total à pagar: R$2,00";
            break;

            case "200 ML":
                          echo "<br>Total à pagar: R$2,50";
            break; 

            case "300 ML":
                          echo "<br>Total à pagar: R$3,00";
            break; 
    }
}

    ?>
</body>
</html>