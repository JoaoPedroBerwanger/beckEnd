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
  <title>Relatório: Vendas por Cliente</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
  <div class="wrap">

    <div class="header">
      <div>Relatório: Vendas por Cliente</div>

      <div style="display:flex; gap:10px;">
        <a class="button" onclick="window.print()">Imprimir</a>
        <a class="button" href="../home.php">Voltar</a>
      </div>
    </div>

    <form method="GET" class="filters">
      <h2>Selecione o cliente e clique em Filtrar</h2>

      <div>
        <label>Cliente:</label>
        <select name="cliente_id" required>
          <option value="">Selecione</option>

          <?php
          $clientes = $conn->query("SELECT id, nome FROM cliente WHERE idnAtivo = 1 ORDER BY nome");
          if ($clientes):
            while ($c = $clientes->fetch_assoc()):
              $selected = (isset($_GET['cliente_id']) && $_GET['cliente_id'] == $c['id']) ? 'selected' : '';
          ?>
              <option value="<?= $c['id'] ?>" <?= $selected ?>>
                <?= htmlspecialchars($c['nome']) ?>
              </option>
          <?php
            endwhile;
          endif;
          ?>
        </select>
      </div>

      <div>
        <button type="submit">Filtrar</button>
      </div>
    </form>

    <?php
    if (isset($_GET['cliente_id'])) {

      $cid = intval($_GET['cliente_id']);

      $select = "SELECT v.id, v.numero, v.totalVenda, v.dataVenda, c.nome AS cliente
                FROM vendas v
                LEFT JOIN cliente c ON c.id = v.idCliente
                WHERE v.idCliente = $cid
                ORDER BY v.id ASC";

      $res = $conn->query($select);

      echo "<div class='print-area'>";

      if ($res && $res->num_rows > 0) {
        $primeiro = $res->fetch_assoc();
        echo "<h3>Cliente: " . htmlspecialchars($primeiro['cliente']) . "</h3>";
        $res->data_seek(0);
      } else {
        echo "<h3>Cliente ID: $cid</h3>";
      }

      echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Número</th>
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
                  <td>R$ " . number_format($r['totalVenda'], 2, ',', '.') . "</td>
                  <td>" . date('d/m/Y H:i', strtotime($r['dataVenda'])) . "</td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='4'>Nenhuma venda encontrada para este cliente.</td></tr>";
      }

      echo " </tbody>
                <tfoot>
                    <tr>
                        <td colspan='2'><strong>Total do Cliente:</strong></td>
                        <td><strong>R$ " . number_format($soma, 2, ',', '.') . "</strong></td>
                        <td></td>
                      </tr>
                  </tfoot>
              </table>
            </div>";
    }
    ?>
  </div>
</body>

</html>