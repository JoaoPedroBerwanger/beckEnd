<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit;
}

include "../funcoes.php";

$modo = $_GET['modo'] ?? 'novo';
$id   = intval($_GET['id'] ?? 0);

$marca = ['descricao' => '', 'idnAtivo' => 1];

if ($modo === 'editar' && $id > 0) {
    $query = $conn->prepare("SELECT * FROM marca WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $marca = $query->get_result()->fetch_assoc();
}

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
      <div><?= $modo === 'novo' ? 'Nova Marca' : 'Editar Marca' ?></div>
      <a class="button" href="marca_consulta.php">Voltar</a>
    </div>

    <div class="form-card">
        <form method="POST" action="../funcoes.php">

            <input type="hidden" name="acao" value="<?= $modo === 'editar' ? 'editarMarca' : 'addMarca' ?>">

            <?php if ($modo === 'editar'): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>

            <label>Descrição</label>
            <input type="text" name="descricao" value="<?= htmlspecialchars($marca['descricao']) ?>" required>

            <?php if ($modo === 'editar'): ?>
            <label>Ativo</label>
            <select name="idnAtivo">
                <option value="1" <?= $marca['idnAtivo'] ? 'selected' : '' ?>>Sim</option>
                <option value="0" <?= !$marca['idnAtivo'] ? 'selected' : '' ?>>Não</option>
            </select>
            <?php endif; ?>

            <div class="actions">
                <button type="submit" class="button green">Salvar</button>
                <a class="button" href="marca_consulta.php">Cancelar</a>
            </div>

        </form>
    </div>

</div>
</body>
</html>
