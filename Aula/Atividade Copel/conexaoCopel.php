<?php

if(isset($_POST["acao"])){
    if($_POST["acao"] == "inserir")
        inserirDados();
    if($_POST["acao"]=="alterar"){
        alterarDados();
    }
}

function abrirBanco(){
    $connection = new mysqli("localhost","root","", "consumo_energia");
    return $connection;
}

function inserirDados(){
    $banco = abrirBanco();
    $sql = "INSERT INTO cliente(nome, sexo, endereco, cep, bairro,
    cpf, nascimento, data_vencimento, unidade_consumidora, kwh, valor_total) 
    VALUES 
    ('{$_POST["nome"]}',
    '{$_POST["sexo"]}',
    '{$_POST["endereco"]}',
    '{$_POST["cep"]}',
    '{$_POST["bairro"]}',
    '{$_POST["cpf"]}', 
    '{$_POST["nascimento"]}', 
    '{$_POST["vencimento"]}',
    '{$_POST["unConsumidora"]}',
    '{$_POST["kwh"]}',
    '{$_POST["valorTotal"]}'
    )";
    $banco->query($sql);
    $banco->close();
    voltarIndex();
}

function voltarIndex(){
    header("location:index.php");
}

function SelecionarUsuarioId($id) {
    $banco = abrirBanco();
    $sql = "select * from usuario where id=" . $id;
    $resultado = $banco->query($sql);
    var_dump($resultado);
    $usuario = mysqli_fetch_assoc($resultado);

    return $usuario;
}

function alterarDados()
{
    $banco = abrirBanco();
    $sql = "UPDATE cliente SET 
        nome='{$_POST["nome"]}',
        sexo='{$_POST["sexo"]}',
        endereco='{$_POST["endereco"]}',
        cep='{$_POST["cep"]}',
        bairro='{$_POST["bairro"]}'
        cpf='{$_POST["cpf"]}'
        nascimento='{$_POST["nascimento"]}',
        vencimento='{$_POST["vencimento"]}',
        unConsumidora='{$_POST["unConsumidora"]}',
        kwh='{$_POST["kwh"]}',
        valorTotal='{$_POST["valorTotal"]}',
        WHERE id='{$_POST["id"]}'";
    $banco->query($sql);
    $banco->close();
    voltarIndex();
}

function listarUsuarios(){
    $banco = abrirBanco();
    $sql="select * from usuario order by nome";
    $resultado=$banco->query($sql);
    while ($row=mysqli_fetch_array($resultado)){
        $grupo[]=$row;
    }
    return $grupo;

}

?>