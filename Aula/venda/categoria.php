<?php
include 'config.php';

// Adicionar categoria
if (isset($_POST['add'])) {
    $nome = $_POST['nome'];
    $conn->query("INSERT INTO categoria (nome) VALUES ('$nome')");
}

// Atualizar categoria
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $conn->query("UPDATE categoria SET nome='$nome' WHERE id=$id");
}

// Excluir categoria
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM categoria WHERE id=$id");
}

// Buscar todas as categorias
$categorias = $conn->query("SELECT * FROM categoria");
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Categoria</title>
</head>
<body>
    <h1>CRUD Categoria</h1>

    <!-- Formulário para adicionar categoria -->
    <h2>Adicionar Categoria</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome da Categoria" required>
        <button type="submit" name="add">Adicionar</button>
    </form>

    <hr>

    <!-- Lista de categorias -->
    <h2>Lista de Categorias</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        <?php while ($categoria = $categorias->fetch_assoc()): ?>
            <tr>
                <td><?= $categoria['id'] ?></td>
                <td><?= $categoria['nome'] ?></td>
                <td>
                    <!-- Botão para exibir o formulário de edição -->
                    <form method="GET" style="display:inline;">
                        <input type="hidden" name="edit_id" value="<?= $categoria['id'] ?>">
                        <button type="submit">Editar</button>
                    </form>

                    <!-- Formulário para excluir categoria -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                        <button type="submit" name="delete" onclick="return confirm('Deseja excluir esta categoria?')">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Formulário de edição (apenas se solicitado) -->
    <?php if (isset($_GET['edit_id'])): ?>
        <?php
        $id = $_GET['edit_id'];
        $resultado = $conn->query("SELECT * FROM categoria WHERE id=$id");
        $categoria = $resultado->fetch_assoc();
        ?>
        <h2>Editar Categoria</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
            <input type="text" name="nome" value="<?= $categoria['nome'] ?>" required>
            <button type="submit" name="update">Atualizar</button>
        </form>
    <?php endif; ?>
</body>
</html>
