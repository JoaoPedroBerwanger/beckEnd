<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

require_once '../funcoes.php';

$produtos = listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Produtos</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div>Produtos</div>
      <div><a class="button" href="../home.php">Voltar</a></div>
    </div>

    <div id="ok" class="notice" style="display:none;"></div>
    <div id="erro" class="error" style="display:none;"></div>

    <a class="button" href="produto_form.php?modo=novo">Novo Produto</a>

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
                <a class="button" href="produto_form.php?modo=editar&id=<?= $prod['id'] ?>">Editar</a>

                <form method="POST" action="../funcoes.php" style="display:inline;">
                  <input type="hidden" name="acao" value="delProduto">
                  <input type="hidden" name="id" value="<?= $prod['id'] ?>">
                  <button type="submit" class="button"
                    onclick="return confirm('Excluir este produto?')">
                    Excluir
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8">Nenhum produto encontrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
  <script src="../assets/js/alertas.js"></script>
</body>
</html>
