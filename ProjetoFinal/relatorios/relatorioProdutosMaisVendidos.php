<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

require_once '../funcoes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Relatório: Produtos Mais Vendidos</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div>Relatório: Produtos Mais Vendidos</div>
      <div style="display:flex; gap:10px;">
        <a class="button" onclick="window.print()">Imprimir</a>
        <a class="button" href="../home.php">Voltar</a>
      </div>
    </div>

    <div class="form">

      <h2 style="margin-bottom: 20px;">Ranking dos Produtos Mais Vendidos</h2>

      <?php
      $query = "SELECT p.id, p.descricao, SUM(vp.quantidade) AS qtd
              FROM venda_produtos vp
              INNER JOIN produto p ON p.id = vp.idProduto
              GROUP BY p.id, p.descricao
              ORDER BY qtd DESC";
      $res = $conn->query($query);
      ?>

      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Quantidade Vendida</th>
          </tr>
        </thead>
        <tbody>

          <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($r = $res->fetch_assoc()): ?>
              <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['descricao']) ?></td>
                <td><?= $r['qtd'] ?></td>
              </tr>
            <?php endwhile; ?>

          <?php else: ?>
            <tr>
              <td colspan="3">Sem vendas registradas.</td>
            </tr>
          <?php endif; ?>

        </tbody>
      </table>

    </div>

  </div>
</body>

</html>