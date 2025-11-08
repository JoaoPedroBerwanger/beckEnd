<?php
require_once "conexao.php";
if (session_status() === PHP_SESSION_NONE) {
  session_start();
};

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($nome !== '' && $login !== '' && $senha !== '') {
        $senhaMD5 = md5($senha);
        $stmt = $conn->prepare("INSERT INTO usuario (nome, login, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $login, $senhaMD5);
        if ($stmt->execute()) {
            echo "<div class='notice'>Usuário cadastrado com sucesso! <a href='index.html'>Ir para o login</a></div>";
        } else {
            echo "<div class='error'>Erro ao cadastrar usuário: " . htmlspecialchars($conn->error) . "</div>";
        }
    } else {
        echo "<div class='error'>Preencha todos os campos.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Novo Usuário</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body class="bg">
    <div class="card">
        <h2>Novo Usuário</h2>
        <form method="POST" action="">
            <label>Nome completo</label>
            <input type="text" name="nome" required>

            <label>Login</label>
            <input type="text" name="login" required>

            <label>Senha</label>
            <input type="password" name="senha" required>

            <button type="submit">Cadastrar</button>
        </form>
        <p><a class="back" href="index.html">⟵ Voltar ao Login</a></p>
    </div>
</body>

</html>