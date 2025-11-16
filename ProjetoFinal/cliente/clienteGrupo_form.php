<?php
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit;
}

require_once '../funcoes.php';

$modo = $_GET['modo'] ?? 'novo';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$grupo = ['descricao' => '', 'idnAtivo' => 1];

if ($modo === 'editar' && $id > 0) {
    $query = $conn->prepare("SELECT * FROM cliente_grupo WHERE id = $id");
    $query->execute();
    $res = $query->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Grupos de Parceiros</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <script src="../assets/js/alertas.js"></script>
</head>

<body>
<div class="wrap">

  <div class="header">
    <div><?= $modo === 'novo' ? "Novo Grupo" : "Editar Grupo" ?></div>
    <div><a class="button" href="clienteGrupo_consulta.php">Voltar</a></div>
  </div>

  <div class="form-card">
    <form method="POST" action="../funcoes.php">

      <input type="hidden" name="acao"
             value="<?= $modo === 'editar' ? 'editarGrupoCliente' : 'addGrupoCliente'; ?>">

      <?php if ($modo === 'editar'): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
      <?php endif; ?>

      <label>Descrição</label>
      <input type="text" name="descricao" value="<?= htmlspecialchars($grupo['descricao']); ?>" required>

      <?php if ($modo === 'editar'): ?>
        <label>Ativo</label>
        <select name="idnAtivo">
          <option value="1" <?= $grupo['idnAtivo'] ? 'selected' : '' ?>>Sim</option>
          <option value="0" <?= !$grupo['idnAtivo'] ? 'selected' : '' ?>>Não</option>
        </select>
      <?php endif; ?>

      <div class="actions">
        <button type="submit" class="button green">Salvar</button>
        <a class="button" href="clienteGrupo_consulta.php">Cancelar</a>
      </div>

    </form>
  </div>
</div>
</body>
</html>
