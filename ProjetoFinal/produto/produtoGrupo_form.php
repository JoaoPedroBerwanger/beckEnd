<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

require_once '../funcoes.php';

$modo = $_GET['modo'] ?? 'novo';
$id   = isset($_GET['id']) ? intval($_GET['id']) : 0;

$grupo = ['id' => 0, 'descricao' => '', 'idnAtivo' => 1];

if ($modo === 'editar' && $id > 0) {
  $res = $conn->query("SELECT * FROM produto_grupo WHERE id = $id");
  if ($res && $res->num_rows > 0) {
    $grupo = $res->fetch_assoc();
  }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title><?= $modo === 'editar' ? 'Editar Grupo' : 'Novo Grupo' ?></title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <script src="../assets/js/alertas.js"></script>
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div><?= $modo === "editar" ? "Editar Grupo" : "Novo Grupo" ?></div>
      <div><a class="button" href="produtoGrupo_consulta.php">Voltar</a></div>
    </div>

    <div class="form-card">

      <form method="POST" action="../funcoes.php">

        <input type="hidden" name="acao"
          value="<?= $modo === 'editar' ? 'editGrupoProduto' : 'addGrupoProduto' ?>">

        <input type="hidden" name="id" value="<?= $grupo['id'] ?>">

        <label>Descrição</label>
        <input type="text" name="descricao" required
          value="<?= htmlspecialchars($grupo['descricao']) ?>">

        <?php if ($modo === 'editar'): ?>
          <label>Ativo</label>
          <select name="idnAtivo">
            <option value="1" <?= $grupo['idnAtivo'] ? 'selected' : '' ?>>Sim</option>
            <option value="0" <?= !$grupo['idnAtivo'] ? 'selected' : '' ?>>Não</option>
          </select>
        <?php endif; ?>


        <div class="actions">
          <button type="submit" class="button green">Salvar</button>
          <a class="button" href="produtoGrupo_consulta.php">Cancelar</a>
        </div>
      </form>

    </div>

  </div>
</body>

</html>