<?php
include 'config.php';

// Adicionar usuário
if (isset($_POST['add'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $conn->query("INSERT INTO usuario (nome, email, senha) VALUES ('$nome', '$email', '$senha')");
}

// Atualizar usuário
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;

    if ($senha) {
        $conn->query("UPDATE usuario SET nome='$nome', email='$email', senha='$senha' WHERE id=$id");
    } else {
        $conn->query("UPDATE usuario SET nome='$nome', email='$email' WHERE id=$id");
    }
}

// Excluir usuário
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM usuario WHERE id=$id");
}

// Buscar todos os usuários
$usuarios = $conn->query("SELECT * FROM usuario");
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Usuário</title>
</head>
<body>
    <h1>CRUD Usuário</h1>

    <!-- Formulário para adicionar um novo usuário -->
    <h2>Adicionar Usuário</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit" name="add">Adicionar</button>
    </form>

    <hr>

    <!-- Lista de usuários -->
    <h2>Lista de Usuários</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?= $usuario['id'] ?></td>
                <td><?= $usuario['nome'] ?></td>
                <td><?= $usuario['email'] ?></td>
                <td>
                    <!-- Botão para exibir o formulário de edição -->
                    <form method="GET" style="display:inline;">
                        <input type="hidden" name="edit_id" value="<?= $usuario['id'] ?>">
                        <button type="submit">Editar</button>
                    </form>
                    
                    <!-- Formulário para excluir usuário -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                        <button type="submit" name="delete" onclick="return confirm('Deseja excluir este usuário?')">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Formulário de edição (apenas se solicitado) -->
    <?php if (isset($_GET['edit_id'])): ?>
        <?php
        $id = $_GET['edit_id'];
        $resultado = $conn->query("SELECT * FROM usuario WHERE id=$id");
        $usuario = $resultado->fetch_assoc();
        ?>
        <h2>Editar Usuário</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
            <input type="text" name="nome" value="<?= $usuario['nome'] ?>" required>
            <input type="email" name="email" value="<?= $usuario['email'] ?>" required>
            <input type="password" name="senha" placeholder="Nova Senha (opcional)">
            <button type="submit" name="update">Atualizar</button>
        </form>
    <?php endif; ?>
</body>
</html>
