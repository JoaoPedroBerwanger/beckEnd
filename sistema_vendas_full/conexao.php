<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_vendas";
$conn = new mysqli($servidor, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
