<meta charset="UTF-8">

<form name="dadosCliente" action="conexaoCopel.php" method="post">
    <table border = "1">
        <body>
            <tr>
                <td>Nome</td>
                <td><input type="text" name="nome" value=""></td>
            </tr>
            <tr>
                <td>Sexo</td>
                <td><input type="text" name="sexo" value=""></td>
            </tr>
            <tr>
                <td>Endereço</td>
                <td><input type="text" name="endereco" value=""></td>
            </tr>
            <tr>
                <td>CEP</td>
                <td><input type="text" name="cep" value=""></td>
            </tr>
            <tr>
                <td>Bairro</td>
                <td><input type="text" name="bairro" value=""></td>
            </tr>
            <tr>
                <td>CPF</td>
                <td><input type="text" name="cpf" value=""></td>
            </tr>
            <tr>
                <td>Data de Nascimento</td>
                <td><input type="text" name="nascimento" value=""></td>
            </tr>
            <tr>
                <td>Data de Vencimento</td>
                <td><input type="text" name="vencimento" value=""></td>
            </tr>
            <tr>
                <td>Unidade Consumidora</td>
                <td><input type="text" name="unConsumidora" value=""></td>
            </tr>
            <tr>
                <td>Kwh</td>
                <td><input type="decimal" name="kwh" value=""></td>
            </tr>
            <tr>
                <td>Valor Total</td>
                <td><input type="decimal" name="valorTotal" value=""></td>
            </tr>
            <tr>
                <td><input type="hidden" name="acao" value="inserir"></td>
                <td><input type="submit" name="enviar" value="Enviar"></td>
            </tr>    
        </body>
        
    </table>
</form>