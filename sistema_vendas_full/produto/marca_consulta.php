<?php
include "../funcoes.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit;
}

$select = $conn->query("SELECT id, descricao, idnAtivo FROM marca ORDER BY descricao");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Marcas</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
<div class="wrap">

    <div class="header">
      <div>Cadastro de Marcas</div>
      <a class="button" href="../home.php">Voltar</a>
    </div>

    <div class="form-card">
        <a href="marca_form.php?modo=novo" class="button">+ Nova Marca</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($select && $select->num_rows > 0): ?>
            <?php while ($r = $select->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['descricao']) ?></td>
                    <td><?= $r['idnAtivo'] ? 'Sim' : 'Não' ?></td>

                    <td>
                        <a href="marca_form.php?modo=editar&id=<?= $r['id'] ?>">Editar</a>

                        <form action="../funcoes.php" method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="delMarca">
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button type="submit" class="link-btn" onclick="return confirm('Deseja remover esta marca?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">Nenhuma marca cadastrada.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>
