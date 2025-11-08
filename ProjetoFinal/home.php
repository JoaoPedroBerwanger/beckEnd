<?php

session_start();

if (!isset($_SESSION['logado'])) {
    header('Location: index.php');
    exit;
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Sistema Copel</title>
</head>

<body>
    <h2>Bem-vindo ao Sistema Copel</h2>

    <form action="cadCliente.php" method="GET">
        <button type="submit">Cadastrar Cliente</button>
    </form>

    <form action="cadUsuario.php" method="GET">
        <button type="submit">Cadastrar Usuário</button>
    </form>

    <form action="consultarClientes.php" method="GET">
        <button type="submit">Consultar Clientes</button>
    </form>

    <form action="consultarUsuarios.php" method="GET">
        <button type="submit">Consultar Usuários</button>
    </form>

    <form action="relatorioConsumo.php" method="GET">
        <button type="submit">Relatório: Maiores Consumos</button>
    </form>

    <form action="relatorioVencimento.php" method="GET">
        <button type="submit">Relatório: Maior Data de Vencimento</button>
    </form>

    <form action="conexao.php" method="POST">
        <input type="hidden" name="acao" value="logout">
        <button type="submit">Sair</button>
    </form>

</body>
</html>
