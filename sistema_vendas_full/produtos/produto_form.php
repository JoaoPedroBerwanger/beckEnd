<?php
require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

$id = intval($_GET['id'] ?? 0);
$produto = $id > 0 ? obterProduto($id) : ['descricao' => '', 'precoVenda' => '', 'precoCusto' => '', 'idMarcaProduto' => '', 'idGrupoProduto' => '', 'idnAtivo' => 0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dados = [
    'id' => intval($_POST['id'] ?? 0),
    'descricao' => trim($_POST['descricao'] ?? ''),
    'precoVenda' => floatval($_POST['precoVenda'] ?? 0),
    'precoCusto' => floatval($_POST['precoCusto'] ?? 0),
    'idMarcaProduto' => !empty($_POST['idMarcaProduto']) ? intval($_POST['idMarcaProduto']) : null,
    'idGrupoProduto' => !empty($_POST['idGrupoProduto']) ? intval($_POST['idGrupoProduto']) : null,
    'idnAtivo' => isset($_POST['idnAtivo']) ? 1 : 0
  ];

  $ok = salvarProduto($dados);

  if ($ok) {
    header("Location: produto_consulta.php?msg=ok");
    exit;
  } else {
    echo "<div class='error'>Erro ao salvar o produto.</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?= $id > 0 ? 'Editar Produto' : 'Novo Produto' ?></title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
  <div class="wrap">
    <div class="header">
      <div><?= $id > 0 ? 'Editar Produto' : 'Novo Produto' ?></div>
      <div><a class="button" href="produto_consulta.php">⟵ Voltar</a></div>
    </div>

    <div class="form-card">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label>Descrição</label>
        <input type="text" name="descricao" value="<?= htmlspecialchars($produto['descricao']) ?>" required>

        <label>Preço de Venda</label>
        <input type="number" step="0.01" name="precoVenda" value="<?= htmlspecialchars($produto['precoVenda']) ?>">

        <label>Preço de Custo</label>
        <input type="number" step="0.01" name="precoCusto" value="<?= htmlspecialchars($produto['precoCusto']) ?>">

        <label>Marca</label>
        <select name="idMarcaProduto">
          <option value="">-- Selecione --</option>
          <?php foreach (listarMarcas() as $m): ?>
            <option value="<?= $m['id'] ?>" <?= $m['id'] == $produto['idMarcaProduto'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($m['descricao']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label>Grupo de Produto</label>
        <select name="idGrupoProduto">
          <option value="">-- Selecione --</option>
          <?php foreach (listarGruposProduto() as $g): ?>
            <option value="<?= $g['id'] ?>" <?= $g['id'] == $produto['idGrupoProduto'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($g['descricao']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label>Ativo para baixa:</label>
        <input type="checkbox" name="idnAtivo" value="1" <?= $produto['idnAtivo'] ? 'checked' : '' ?>>

        <button type="button">Salvar</button>
        <a class="button" href="produto_consulta.php">Cancelar</a>
      </form>
    </div>
  </div>
</body>
</html>
