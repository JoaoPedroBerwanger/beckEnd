<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php 
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "meuBancoTeste";

    $conn = new mysqli($servername, $username, $password);

    if($conn->connect_error){
        die("Connection failed: " . $conn->$connect_error);
    }

    $sql = "CREATE DATABASE meuBancoTeste";
  
    if($conn->query($sql) === true){
        echo "Banco Criado";
    } else {
        echo "Erro ao criar o banco " . $conn->error;
    }

    $connection = new mysqli($servername, $username, $password, $dbName);

    ?>

</body>
</html>