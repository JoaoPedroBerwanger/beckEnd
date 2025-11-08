<?php

if(isset($_POST["acao"])){
    if($_POST["acao"]=="inserir"){
       inserirUsuario();
    }
    if($_POST["acao"]=="alterar"){
        alterarUsuario();
    }
    if($_POST["acao"]=="excluir"){
        excluirUsuario();
    }
}

function abrirBanco(){
    $conexao= new mysqli("localhost","root","","db_tsi1");
    return $conexao;

}

function inserirUsuario(){
    $banco=abrirBanco();
    $sql="INSERT INTO usuario(nome,nascimento,endereco,bairro)". "VALUES ('{$_POST["nome"]}','{$_POST["nascimento"]}','{$_POST["endereco"]}','{$_POST["bairro"]}')";
    $banco->query($sql);
    $banco->close();

    voltarIndex();

}
function excluirUsuario(){
    $banco=abrirBanco();
    $sql="delete from usuario where id='{$_POST["id"]}'";
    $banco->query($sql);
    $banco->close();
    voltarIndex();

}
function SelecionarUsuarioId($id) {
    $banco = abrirBanco();
    $sql = "select * from usuario where id=" . $id;
    $resultado = $banco->query($sql);
    var_dump($resultado);
    $usuario = mysqli_fetch_assoc($resultado);

    return $usuario;
}

function alterarUsuario()
{
    $banco = abrirBanco();
    $sql = "UPDATE usuario SET nome='{$_POST["nome"]}',nascimento='{$_POST["nascimento"]}',endereco='{$_POST["endereco"]}',bairro='{$_POST["bairro"]}' WHERE id='{$_POST["id"]}'";
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


function voltarIndex(){
    header("location:index.php");
}
?>