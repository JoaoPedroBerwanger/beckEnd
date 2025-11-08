<?php

require_once "conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

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

        <?php if (isset($_GET['erro'])): ?>
            <div class="error">
                <?php
                switch ($_GET['erro']) {
                    case '1':
                        echo "Preencha todos os campos.";
                        break;
                    case 'login_duplicado':
                        echo "Este login já está em uso.";
                        break;
                    case 'db':
                        echo "Erro ao salvar no banco de dados.";
                        break;
                    default:
                        echo "Erro desconhecido.";
                        break;
                }
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="funcoes.php">
            <input type="hidden" name="acao" value="cadUsuario" />

            <label for="nome">Nome completo</label>
            <input type="text" id="nome" name="nome" required />

            <label for="login">Login</label>
            <input type="text" id="login" name="login" required />

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required />

            <div class="actions">
                <button type="submit">Cadastrar</button>
                <a href="index.html" class="button">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>