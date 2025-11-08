<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
</head>

<body>

    <h1>Cadastrar Usuário</h1>

    <form action="conexao.php" method="POST">
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <td><label>Login:</label></td>
                <td><input type="text" name="login" required></td>
            </tr>

            <tr>
                <td><label>Nome:</label></td>
                <td><input type="text" name="nome" required></td>
            </tr>

            <tr>
                <td><label>Senha:</label></td>
                <td><input type="password" name="senha" required></td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="hidden" name="acao" value="cadUsuario">
                    <button type="submit">Salvar</button>
                </td>
            </tr>
        </table>
    </form>

    <br>
    <button onclick="history.back()">Voltar</button>

</body>
</html>