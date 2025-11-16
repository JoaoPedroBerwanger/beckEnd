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
  <title>Relatório: Produtos mais Vendidos</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Relatório: Produtos mais Vendidos</div>
      <div><a class="button" href="../home.php">Voltar</a></div>
    </div>
    <?php
    $sql = "SELECT p.id, p.descricao, SUM(vp.quantidade) AS qtd
            FROM venda_produtos vp
            INNER JOIN produto p ON p.id = vp.idProduto
            GROUP BY p.id, p.descricao
            ORDER BY qtd DESC";
    $res = $conn->query($sql);
    echo "<table class='table'><thead><tr><th>ID</th><th>Produto</th><th>Quantidade Vendida</th></tr></thead><tbody>";
    if ($res && $res->num_rows > 0) {
      while ($r = $res->fetch_assoc()) {
        echo "<tr><td>{$r['id']}</td><td>" . htmlspecialchars($r['descricao']) . "</td><td>{$r['qtd']}</td></tr>";
      }
    } else {
      echo "<tr><td colspan='3'>Sem vendas registradas.</td></tr>";
    }
    echo "</tbody></table>";
    ?>
    <p><a class="button" href="../home.php">Voltar ao Menu</a></p>
  </div>
</body>

</html>