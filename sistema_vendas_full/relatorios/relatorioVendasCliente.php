<?php 
require_once '../funcoes.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Relatório: Vendas por Cliente</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Relatório: Vendas por Cliente</div>
      <div><a class="button" href="../home.php">Voltar</a></div>
    </div>
    <form method="GET" class="filters">
      <div><label>ID do Cliente:</label><input type="number" name="cliente_id" required></div>
      <div><button type="button">Filtrar</button></div>
    </form>
    <?php
    if (isset($_GET['cliente_id'])) {
      $cid = intval($_GET['cliente_id']);
      $sql = "SELECT v.id, v.numero, v.totalVenda, v.dataVenda FROM vendas v WHERE v.idCliente = $cid ORDER BY v.dataVenda DESC";
      $res = $conn->query($sql);
      echo "<table class='table'><thead><tr><th>ID</th><th>Número</th><th>Total (R$)</th><th>Data</th></tr></thead><tbody>";
      $soma = 0;
      if ($res && $res->num_rows > 0) {
        while ($r = $res->fetch_assoc()) {
          $soma += $r['totalVenda'];
          echo "<tr><td>{$r['id']}</td><td>{$r['numero']}</td><td>" . number_format($r['totalVenda'], 2, ',', '.') . "</td><td>" . date('d/m/Y H:i', strtotime($r['dataVenda'])) . "</td></tr>";
        }
      } else {
        echo "<tr><td colspan='4'>Nenhuma venda para este cliente.</td></tr>";
      }
      echo "</tbody></table><div class='notice'><strong>Total do cliente:</strong> R$ " . number_format($soma, 2, ',', '.') . "</div>";
    } else {
      echo "<div class='notice'>Informe o ID do cliente e clique em Filtrar.</div>";
    }
    ?>
    <p><a class="button" href="../home.php">Voltar ao Menu</a></p>
  </div>
</body>

</html>