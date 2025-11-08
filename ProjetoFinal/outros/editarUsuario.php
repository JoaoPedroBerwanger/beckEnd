<?php

include("conexao.php"); 
$id = intval($_POST["id"]);
$usuario = selecionarUsuarioId($id);

?>

<meta charset="UTF-8">
<h1>Editar Usuário</h1>

<form name="dadosUsuario" action="conexao.php" method="POST">
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td>Login</td>
            <td><input type="text" name="login" value="<?= $usuario["login"] ?>" size="30" required></td>
        </tr>
        <tr>
            <td>Nome</td>
            <td><input type="text" name="nome" value="<?= $usuario["nome"] ?>" size="35" required></td>
        </tr>
        <tr>
            <td>Nova Senha</td>
            <td><input type="password" name="senha" placeholder="Deixe em branco para manter a atual"></td>
        </tr>

        <tr>
            <td><input type="hidden" name="acao" value="editarUsuario"></td>
            <td><input type="hidden" name="id" value="<?= $usuario["id"] ?>"></td>
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