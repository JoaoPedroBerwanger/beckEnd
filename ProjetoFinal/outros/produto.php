<?php
include 'config.php';

// Adicionar produto
if (isset($_POST['add'])) {
    $nome = $_POST['nome'];
    $categoria_id = $_POST['categoria_id'];
    $preco = $_POST['preco'];
    $conn->query("INSERT INTO produto (nome, categoria_id, preco) VALUES ('$nome', $categoria_id, $preco)");
}

// Atualizar produto
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $categoria_id = $_POST['categoria_id'];
    $preco = $_POST['preco'];
    $conn->query("UPDATE produto SET nome='$nome', categoria_id=$categoria_id, preco=$preco WHERE id=$id");
}

// Excluir produto
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM produto WHERE id=$id");
}

// Buscar todos os produtos com categorias
$produtos = $conn->query("
    SELECT produto.*, categoria.nome AS categoria_nome 
    FROM produto 
    INNER JOIN categoria ON produto.categoria_id = categoria.id
");

// Buscar todas as categorias para exibição no formulário
$categorias = $conn->query("SELECT * FROM categoria");
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Produto</title>
</head>
<body>
    <h1>CRUD Produto</h1>

    <!-- Formulário para adicionar produto -->
    <h2>Adicionar Produto</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome do Produto" required>
        <select name="categoria_id" required>
            <option value="">Selecione a Categoria</option>
            <?php while ($categoria = $categorias->fetch_assoc()): ?>
                <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="preco" step="0.01" placeholder="Preço" required>
        <button type="submit" name="add">Adicionar</button>
    </form>

    <hr>

    <!-- Lista de produtos -->
    <h2>Lista de Produtos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
        <?php while ($produto = $produtos->fetch_assoc()): ?>
            <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= $produto['nome'] ?></td>
                <td><?= $produto['categoria_nome'] ?></td>
                <td><?= $produto['preco'] ?></td>
                <td>
                    <!-- Botão para exibir o formulário de edição -->
                    <form method="GET" style="display:inline;">
                        <input type="hidden" name="edit_id" value="<?= $produto['id'] ?>">
                        <button type="submit">Editar</button>
                    </form>

                    <!-- Formulário para excluir produto -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                        <button type="submit" name="delete" onclick="return confirm('Deseja excluir este produto?')">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Formulário de edição (apenas se solicitado) -->
    <?php if (isset($_GET['edit_id'])): ?>
        <?php
        $id = $_GET['edit_id'];
        $resultado = $conn->query("SELECT * FROM produto WHERE id=$id");
        $produto = $resultado->fetch_assoc();
        $categorias = $conn->query("SELECT * FROM categoria");
        ?>
        <h2>Editar Produto</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
            <input type="text" name="nome" value="<?= $produto['nome'] ?>" required>
            <select name="categoria_id" required>
                <?php while ($categoria = $categorias->fetch_assoc()): ?>
                    <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $produto['categoria_id'] ? 'selected' : '' ?>>
                        <?= $categoria['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="number" name="preco" step="0.01" value="<?= $produto['preco'] ?>" required>
            <button type="submit" name="update">Atualizar</button>
        </form>
    <?php endif; ?>
</body>
</html>
