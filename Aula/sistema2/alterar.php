<?php
include ("conexao.php");
$usuario= SelecionarUsuarioId($_POST["id"]);


?>
<meta charset="UTF-8">
<form name="dadosCliente" action="conexao.php" method="POST">
    <table border="1">

        <tbody>
        <tr>
            <td>Nome </td>
            <td><input type="text" name="nome" value="<?=$usuario["nome"]?>" size="35" /> </td>
        </tr>
        <tr>
            <td>Nascimento</td>
            <td><input type="date" name="nascimento" value="<?=$usuario["nascimento"]?>" /></td>
        </tr>
        <tr>
            <td>Endereco</td>
            <td><input type="text" name="endereco" value="<?=$usuario["endereco"]?>"size="40" /></td>

        </tr>

        <tr>
            <td>Bairro</td>
            <td><input type="text" name="bairro" value="<?=$usuario["bairro"]?>"size="20"  /></td>
        </tr>
        <tr>
            <td><input type="hidden" name="acao" value="alterar" /></td>
            <td><input type="hidden" name="id" value="<?=$usuario["id"]?>" /></td>

        </tr>
        <td><input type="submit" value="Enviar" name="enviar" /></td>
        </tbody>
    </table>

</form>