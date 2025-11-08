<?php

include("conexao.php");
$clientes = consultarClientes();

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'editado') {
        echo "Cliente atualizado com sucesso!</p>";
    }
}

?>

<meta charset="UTF-8">
<h1>Consultar Clientes</h1>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Endereço</th>
        <th>Bairro</th>
        <th>Data Vencimento</th>
        <th>E-mail</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?= $c["id"] ?></td>
            <td><?= $c["nome"] ?></td>
            <td><?= $c["cpf"] ?></td>
            <td><?= $c["endereco"] ?></td>
            <td><?= $c["bairro"] ?></td>
            <td><?= date('d/m/Y', strtotime($c["data_vencimento"])) ?></td>
            <td><?= $c["email"] ?></td>
            <td>
                <form action="editarCliente.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $c["id"] ?>">
                    <button type="submit">Editar</button>
                </form>

                <form action="conexao.php" method="POST" style="display:inline;">
                    <input type="hidden" name="acao" value="excluirCliente">
                    <input type="hidden" name="id" value="<?= $c["id"] ?>">
                    <button type="submit" onclick="return confirm('Deseja realmente excluir este cliente?')">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="home.php"><button type="button">Voltar ao Menu</button></a>