<?php 
require_once '../funcoes.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Relatório: Vendas por Usuário</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Relatório: Vendas por Usuário</div>
      <div><a class="button" href="../home.php">Voltar</a></div>
    </div>
    <?php
    $sql = "SELECT u.id, u.nome, COUNT(v.id) AS qtd_vendas, COALESCE(SUM(v.totalVenda),0) AS total
            FROM usuario u
            LEFT JOIN vendas v ON v.idUsuario = u.id
            WHERE v.totalVenda > 0
            GROUP BY u.id, u.nome
            ORDER BY total DESC";
    $res = $conn->query($sql);
    echo "<table class='table'><thead><tr><th>ID</th><th>Usuário</th><th>Qtd. Vendas</th><th>Total (R$)</th></tr></thead><tbody>";
    if ($res && $res->num_rows > 0) {
      while ($r = $res->fetch_assoc()) {
        echo "<tr><td>{$r['id']}</td><td>" . htmlspecialchars($r['nome']) . "</td><td>{$r['qtd_vendas']}</td><td>" . number_format($r['total'], 2, ',', '.') . "</td></tr>";
      }
    } else {
      echo "<tr><td colspan='4'>Sem dados.</td></tr>";
    }
    echo "</tbody></table>";
    ?>
    <p><a class="button" href="../home.php">Voltar ao Menu</a></p>
  </div>
</body>

</html>