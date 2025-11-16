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
$id   = intval($_GET['id'] ?? 0);

// valores padrão
$produto = [
  'descricao' => '',
  'precoVenda' => '',
  'precoCusto' => '',
  'idMarcaProduto' => '',
  'idGrupoProduto' => '',
  'idnAtivo' => 1
];

if ($modo === 'editar' && $id > 0) {
  $query = $conn->query("SELECT * FROM produto WHERE id = $id");
  if ($query && $query->num_rows > 0) {
    $produto = $query->fetch_assoc();
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title><?= $modo === "editar" ? "Editar Produto" : "Novo Produto" ?></title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div><?= $modo === "editar" ? "Editar Produto" : "Novo Produto" ?></div>
      <a class="button" href="produto_consulta.php">Voltar</a>
    </div>

    <div class="form-card">
      <form method="POST" action="../funcoes.php">

        <input type="hidden" name="acao"
               value="<?= $modo === 'editar' ? 'editProduto' : 'addProduto' ?>">

        <?php if ($modo === 'editar'): ?>
          <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <label>Descrição</label>
        <input type="text" name="descricao"
               value="<?= htmlspecialchars($produto['descricao']) ?>" required>

        <label>Preço de Venda</label>
        <input type="number" name="precoVenda" step="0.01"
               value="<?= htmlspecialchars($produto['precoVenda']) ?>">

        <label>Preço de Custo</label>
        <input type="number" name="precoCusto" step="0.01"
               value="<?= htmlspecialchars($produto['precoCusto']) ?>">

        <label>Marca</label>
        <select name="idMarcaProduto">
          <option value="">Selecione</option>
          <?php foreach (listarMarcas() as $m): ?>
            <option value="<?= $m['id'] ?>"
              <?= $produto['idMarcaProduto'] == $m['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($m['descricao']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label>Grupo de Produto</label>
        <select name="idGrupoProduto">
          <option value="">Selecione</option>
          <?php foreach (listarGruposProduto() as $g): ?>
            <option value="<?= $g['id'] ?>"
              <?= $produto['idGrupoProduto'] == $g['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($g['descricao']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <?php if ($modo === 'editar'): ?>
          <label>Ativo</label>
          <select name="idnAtivo">
            <option value="1" <?= $produto['idnAtivo'] ? 'selected' : '' ?>>Sim</option>
            <option value="0" <?= !$produto['idnAtivo'] ? 'selected' : '' ?>>Não</option>
          </select>
        <?php endif; ?>

        <div class="actions">
          <button type="submit">Salvar</button>
          <a class="button" href="produto_consulta.php">Cancelar</a>
        </div>

      </form>
    </div>
  </div>
</body>
</html>
