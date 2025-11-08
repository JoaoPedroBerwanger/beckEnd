<html>
<head>
    <meta charset="UTF-8">
    <title>Login de Acesso</title>
</head>

<body>

    <h1>Login Copel</h1>

    <form action="conexao.php" method="POST">
        <table border="1" cellpadding="5" cellspacing="0">

            <tr>
                <td><label>Login:</label></td>
                <td><input type="text" name="login" required></td>
            </tr>

            <tr>
                <td><label>Senha:</label></td>
                <td><input type="password" name="senha" required></td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="hidden" name="acao" value="entrar">
                    <button type="submit" name="btn-entrar">Entrar</button>
                </td>
            </tr>

        </table>
    </form>

    <br>

    <form action="cadUsuario.php" method="get">
        <button type="submit">Cadastrar novo usuário</button>
    </form>

</body>
</html>
