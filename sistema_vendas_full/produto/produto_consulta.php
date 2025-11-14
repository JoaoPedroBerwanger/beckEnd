<?php
require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

if (isset($_GET['excluir'])) {
  $id = intval($_GET['excluir']);
  if ($id > 0) {
    excluirProduto($id);
    echo "<div class='notice'>Registro excluído.</div>";
  }
}

$produtos = listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Consulta de Produtos</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>

  <div class="wrap">
    <div class="header">
      <div>Produtos</div>
      <div><a class="button" href="../home.php">Voltar</a></div>
    </div>

    <a class="button" href="produto_form.php">Novo Produto</a>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Descrição</th>
          <th>Marca</th>
          <th>Grupo</th>
          <th>Preço Venda</th>
          <th>Preço Custo</th>
          <th>Ativo</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($produtos)): ?>
          <?php foreach ($produtos as $prod): ?>
            <tr>
              <td><?= $prod['id'] ?></td>
              <td><?= htmlspecialchars($prod['descricao']) ?></td>
              <td><?= htmlspecialchars($prod['marca'] ?? '-') ?></td>
              <td><?= htmlspecialchars($prod['grupo'] ?? '-') ?></td>
              <td><?= number_format($prod['precoVenda'], 2, ',', '.') ?></td>
              <td><?= number_format($prod['precoCusto'], 2, ',', '.') ?></td>
              <td><?= $prod['idnAtivo'] ? 'Sim' : 'Não' ?></td>
              <td>
                <a class="button" href="produto_form.php?id=<?= $prod['id'] ?>">Editar</a>
                <a class="button" href="?excluir=<?= $p['id'] ?>" onclick="return confirm('Excluir registro?')">Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="8">Nenhum produto encontrado.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  
</body>
</html>
