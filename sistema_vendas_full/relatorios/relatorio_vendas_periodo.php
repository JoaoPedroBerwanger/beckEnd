<?php 
require_once '../funcoes.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Relatório: Vendas por Período</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Relatório: Vendas por Período</div>
      <div><a class="button" href="../home.php">⟵ Voltar</a></div>
    </div>
    <form method="GET" class="filters">
      <div><label>De:</label><input type="date" name="de" required></div>
      <div><label>Até:</label><input type="date" name="ate" required></div>
      <div><button type="button">Filtrar</button></div>
    </form>
    <?php
    if (isset($_GET['de'], $_GET['ate'])) {
      $de = $_GET['de'];
      $ate = $_GET['ate'];
      $sql = "SELECT v.id, v.numero, v.totalVenda, v.dataVenda, u.nome AS usuario
              FROM vendas v LEFT JOIN usuario u ON u.id=v.idUsuario
              WHERE DATE(v.dataVenda) BETWEEN '$de' AND '$ate' ORDER BY v.dataVenda DESC";
      $res = $conn->query($sql);
      echo "<table class='table'><thead><tr><th>ID</th><th>Número</th><th>Usuário</th><th>Total (R$)</th><th>Data</th></tr></thead><tbody>";
      $soma = 0;
      if ($res && $res->num_rows > 0) {
        while ($r = $res->fetch_assoc()) {
          $soma += $r['totalVenda'];
          echo "<tr><td>{$r['id']}</td><td>{$r['numero']}</td><td>" . htmlspecialchars($r['usuario']) . "</td><td>" . number_format($r['totalVenda'], 2, ',', '.') . "</td><td>" . date('d/m/Y H:i', strtotime($r['dataVenda'])) . "</td></tr>";
        }
      } else {
        echo "<tr><td colspan='5'>Nenhuma venda no período.</td></tr>";
      }
      echo "</tbody></table><div class='notice'><strong>Total do período:</strong> R$ " . number_format($soma, 2, ',', '.') . "</div>";
    } else {
      echo "<div class='notice'>Selecione o período e clique em Filtrar.</div>";
    }
    ?>
    <p><a class="button" href="../home.php">⟵ Voltar ao Menu</a></p>
  </div>
</body>

</html>