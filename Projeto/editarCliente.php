<?php

include("conexao.php");
$id = intval($_POST["id"]);
$cliente = selecionarClienteId($id);

?>

<meta charset="UTF-8">
<h1>Editar Cliente</h1>

<form name="dadosCliente" action="conexao.php" method="POST">
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td>Nome</td>
            <td><input type="text" name="nome" value="<?= $cliente["nome"] ?>" size="35" required></td>
        </tr>
        <tr>
            <td>Sexo</td>
            <td>
                <select name="sexo" required>
                    <option value="">Selecione</option>
                    <option value="M" <?= $cliente["sexo"] == "M" ? "selected" : "" ?>>Masculino</option>
                    <option value="F" <?= $cliente["sexo"] == "F" ? "selected" : "" ?>>Feminino</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Endereço</td>
            <td><input type="text" name="endereco" value="<?= $cliente["endereco"] ?>" size="40"></td>
        </tr>
        <tr>
            <td>Bairro</td>
            <td><input type="text" name="bairro" value="<?= $cliente["bairro"] ?>" size="20"></td>
        </tr>
        <tr>
            <td>CEP</td>
            <td><input type="text" name="cep" value="<?= $cliente["cep"] ?>"></td>
        </tr>
        <tr>
            <td>CPF</td>
            <td><input type="text" name="cpf" value="<?= $cliente["cpf"] ?>" maxlength="14" required></td>
        </tr>
        <tr>
            <td>Nascimento</td>
            <td><input type="date" name="nascimento" value="<?= $cliente["nascimento"] ?>"></td>
        </tr>
        <tr>
            <td>Data de Vencimento</td>
            <td><input type="date" name="data_vencimento" value="<?= $cliente["data_vencimento"] ?>"></td>
        </tr>
        <tr>
            <td>Unidade Consumidora</td>
            <td><input type="text" name="unidade_consumidora" value="<?= $cliente["unidade_consumidora"] ?>"></td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td><input type="email" name="email" value="<?= $cliente["email"] ?>"></td>
        </tr>
        <tr>
            <td>Kwh</td>
            <td><input type="number" name="kwh" step="0.01" value="<?= $cliente["kwh"] ?>"></td>
        </tr>
        <tr>
            <td>Valor Total</td>
            <td><input type="number" name="valor_total" step="0.01" value="<?= $cliente["valor_total"] ?>"></td>
        </tr>
        <tr>
            <td>Site</td>
            <td><input type="text" name="site" value="<?= $cliente["site"] ?>"></td>
        </tr>

        <tr>
            <td><input type="hidden" name="acao" value="editarCliente"></td>
            <td><input type="hidden" name="id" value="<?= $cliente["id"] ?>"></td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="Salvar Alterações">
            </td>
        </tr>
    </table>
</form>

<br>
<button onclick="history.back()">Voltar</button>