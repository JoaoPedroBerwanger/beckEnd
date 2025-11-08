<?php

if(isset($_POST["acao"])){
    if($_POST["acao"] == "inserir")
        inserirUsuario();
}

function abrirBanco(){
    $connection = new mysqli("localhost","root","", "db_cliente");
    return $connection;
}

function inserirUsuario(){
    $banco = abrirBanco();
    $sql = "INSERT INTO usuario(nome, nascimento, endereco, bairro) 
        VALUES ('{$_POST["nome"]}', '{$_POST["nascimento"]}', '{$_POST["endereco"]}', '{$_POST["bairro"]}')";
    $banco->query($sql);
    $banco->close();
    voltarIndex();
}

function voltarIndex(){
    header("location:inserir.php");
}

?>