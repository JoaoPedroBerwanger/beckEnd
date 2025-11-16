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
  <title>Relatório: Vendas por Período</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div>Relatório: Vendas por Período</div>

      <div style="display:flex; gap:10px;">
        <a class="button" onclick="window.print()">Imprimir</a>
        <a class="button" href="../home.php">Voltar</a>
      </div>
    </div>

    <form method="GET" class="filters" style="margin-bottom:20px;">
      <h3>Selecione o período e clique em Filtrar</h3>

      <div style="display:flex; gap:20px; align-items:center; flex-wrap:wrap;">

        <div>
          <label>De:</label>
          <input type="date" name="de" required
            value="<?= $_GET['de'] ?? '' ?>">
        </div>

        <div>
          <label>Até:</label>
          <input type="date" name="ate" required
            value="<?= $_GET['ate'] ?? '' ?>">
        </div>

        <div>
          <button type="submit">Filtrar</button>
        </div>

      </div>
    </form>

    <?php

    if (!empty($_GET['de']) && !empty($_GET['ate'])) {

      $de = $_GET['de'];
      $ate = $_GET['ate'];

      $query = "SELECT v.id, v.numero, v.totalVenda, v.dataVenda, u.nome AS usuario
        FROM vendas v
        LEFT JOIN usuario u ON u.id = v.idUsuario
        WHERE DATE(v.dataVenda) BETWEEN '$de' AND '$ate'
        ORDER BY v.dataVenda ASC";

      $res = $conn->query($query);

      echo "<table class='table print-area'>
        <thead>
            <tr>
              <th>ID</th>
              <th>Número</th>
              <th>Usuário</th>
              <th>Total (R$)</th>
              <th>Data</th>
            </tr>
        </thead>
      <tbody>";

      $soma = 0;

      if ($res && $res->num_rows > 0) {

        while ($r = $res->fetch_assoc()) {
          $soma += $r['totalVenda'];

          echo "<tr>
                  <td>{$r['id']}</td>
                  <td>{$r['numero']}</td>
                  <td>" . htmlspecialchars($r['usuario']) . "</td>
                  <td>" . number_format($r['totalVenda'], 2, ',', '.') . "</td>
                  <td>" . date('d/m/Y H:i', strtotime($r['dataVenda'])) . "</td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5'>Nenhuma venda encontrada no período.</td></tr>";
      }

      echo "
        </tbody>
        <tfoot>
            <tr>
                <td colspan='3'><strong>Total do período:</strong></td>
                <td><strong>R$ " . number_format($soma, 2, ',', '.') . "</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>";
    }
    ?>

  </div>
</body>

</html>