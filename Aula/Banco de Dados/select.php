<?php

consultarUsuario();

function abrirBanco(){
    $connection = new mysqli("localhost","root","", "db_cliente");
    return $connection;
}

function consultarUsuario(){
    $banco = abrirBanco();
    $sql = "select id, nome, nascimento, bairro, endereco  from usuario";
    $resposta = $banco->query($sql);

    if (!$resposta) {
        die("Erro na consulta: " . $banco->error);
    }

    imprimir($resposta);

    $banco->close();
}

function imprimir($resposta){
    if ($resposta->num_rows > 0) {
        while ($linha = $resposta->fetch_assoc()) {
            echo "ID: " . $linha["id"] 
            . " - Nome: " . $linha["nome"] 
            . " - Nascimento: " . $linha["nascimento"] 
            . " - Endereço: " . $linha["endereco"] 
            . " - Bairro: " . $linha["bairro"] . "<br>";
        }
    } else {
        echo "Nenhum usuário encontrado.";
    }
}

?>