<meta charset="UTF-8">

<form name="dadosCliente" action="conexao.php" method="post">
    <table border = "1">
        <body>
            <tr>
                <td>Nome</td>
                <td><input type="text" name="nome" value=""></td>
            </tr>
            <tr>
                <td>Nascimento</td>
                <td><input type="text" name="nascimento" value=""></td>
            </tr>
            <tr>
                <td>Endereço</td>
                <td><input type="text" name="endereco" value=""></td>
            </tr>
            <tr>
                <td>Bairro</td>
                <td><input type="text" name="bairro" value=""></td>
            </tr>
            <tr>
                <td><input type="hidden" name="acao" value="inserir"></td>
                <td><input type="submit" name="enviar" value="Enviar"></td>
            </tr>    
        </body>
        
    </table>
</form>