<?php
include ("conexaoCopel.php");
$usuario= SelecionarUsuarioId($_POST["id"]);


?>
<meta charset="UTF-8">
<form name="dadosCliente" action="conexaoCopel.php" method="POST">
    <table border="1">

        <tbody>
        <tr>
            <td>Nome</td>
            <td><input type="text" name="nome" value="<?=$usuario["nome"]?>" size="35" /> </td>
        </tr>
        <tr>
            <td>Sexo</td>
            <td><input type="text" name="sexo" value="<?=$usuario["sexo"]?>" size="10" /> </td>
        </tr>
        <tr>
            <td>Endereco</td>
            <td><input type="text" name="endereco" value="<?=$usuario["endereco"]?>"size="40" /></td>
        </tr>
        <tr>
            <td>CEP</td>
            <td><input type="text" name="cep" value="<?=$usuario["cep"]?>"size="10" /></td>
        </tr>
        <tr>
            <td>Bairro</td>
            <td><input type="text" name="bairro" value="<?=$usuario["bairro"]?>"size="35" /></td>
        </tr>
        <tr>
            <td>CPF</td>
            <td><input type="text" name="cpf" value="<?=$usuario["cpf"]?>"size="15" /></td>
        </tr>
        <tr>
            <td>Data de Nascimento</td>
            <td><input type="text" name="nascimento" value="<?=$usuario["nascimento"]?>"size="10" /></td>
        </tr>
        <tr>
            <td>Data de Vencimento</td>
            <td><input type="text" name="vencimento" value="<?=$usuario["vencimento"]?>"size="10" /></td>
        </tr>            
        <tr>
            <td>Unidade Consumidora</td>
            <td><input type="text" name="unConsumidora" value="<?=$usuario["unConsumidora"]?>"size="10" /></td>
        </tr>           
        <tr>
            <td>Kwh</td>
            <td><input type="decimal" name="kwh" value="<?=$usuario["kwh"]?>"size="10" /></td>
        </tr>
        <tr>                
            <td>Valor Total</td>
            <td><input type="decimal" name="valorTotal" value="<?=$usuario["valorTotal"]?>"size="10" /></td>
       </tr>
        <tr>
            <td><input type="hidden" name="acao" value="alterar" /></td>
            <td><input type="hidden" name="id" value="<?=$usuario["id"]?>" /></td>

        </tr>
        <td><input type="submit" value="Enviar" name="enviar" /></td>
        </tbody>
    </table>

</form>