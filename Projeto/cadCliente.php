<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Cliente</title>
</head>

<body>

    <h1>Cadastrar Cliente</h1>

    <form action="conexao.php" method="POST">
        <table border="1" cellpadding="5" cellspacing="0">

            <tr>
                <td><label>Nome:</label></td>
                <td><input type="text" name="nome" required></td>
            </tr>

            <tr>
                <td><label>Sexo:</label></td>
                <td>
                    <select name="sexo" required>
                        <option value="">Selecione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label>Endereço:</label></td>
                <td><input type="text" name="endereco" required></td>
            </tr>

            <tr>
                <td><label>CEP:</label></td>
                <td><input type="text" name="cep" maxlength="10"></td>
            </tr>

            <tr>
                <td><label>Bairro:</label></td>
                <td><input type="text" name="bairro"></td>
            </tr>

            <tr>
                <td><label>CPF:</label></td>
                <td><input type="text" name="cpf" maxlength="14" required></td>
            </tr>

            <tr>
                <td><label>Data de Nascimento:</label></td>
                <td><input type="date" name="nascimento"></td>
            </tr>

            <tr>
                <td><label>Data de Vencimento:</label></td>
                <td><input type="date" name="data_vencimento"></td>
            </tr>

            <tr>
                <td><label>Unidade Consumidora:</label></td>
                <td><input type="text" name="unidade_consumidora"></td>
            </tr>

            <tr>
                <td><label>E-mail:</label></td>
                <td><input type="email" name="email"></td>
            </tr>

            <tr>
                <td><label>Consumo (Kwh):</label></td>
                <td><input type="number" step="0.01" name="kwh"></td>
            </tr>

            <tr>
                <td><label>Valor Total:</label></td>
                <td><input type="number" step="0.01" name="valor_total"></td>
            </tr>

            <tr>
                <td><label>Site:</label></td>
                <td><input type="text" name="site"></td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="hidden" name="acao" value="cadCliente">
                    <button type="submit">Salvar Cliente</button>
                </td>
            </tr>
        </table>
    </form>

    <br>
    <button onclick="history.back()">Voltar</button>

</body>
</html>
