<?php

include("conexao.php");
$usuarios = consultarUsuarios();

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'editado') {
        echo "Usuário atualizado com sucesso!</p>";
    }
}

?>

<meta charset="UTF-8">
<h1>Consultar Usuários</h1>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Login</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u["id"] ?></td>
            <td><?= $u["login"] ?></td>
            <td><?= $u["nome"] ?></td>
            <td>
                <form action="editarUsuario.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $u["id"] ?>">
                    <button type="submit">Editar</button>
                </form>

                <form action="conexao.php" method="POST" style="display:inline;">
                    <input type="hidden" name="acao" value="excluirUsuario">
                    <input type="hidden" name="id" value="<?= $u["id"] ?>">
                    <button type="submit" onclick="return confirm('Deseja realmente excluir este usuário?')">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="home.php"><button type="button">Voltar ao Menu</button></a>
