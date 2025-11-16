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
  <title>Relatório: Clientes por Grupo</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div>Relatório: Clientes por Grupo</div>
      <div style="display:flex; gap:10px;">
        <a class="button" onclick="window.print()">Imprimir</a>
        <a class="button" href="../home.php">Voltar</a>
      </div>
    </div>

    <div class="form">

      <h2 style="margin-bottom: 20px;">Quantidade de Clientes por Grupo</h2>

      <?php
      $query = "SELECT g.id, g.descricao AS grupo, COUNT(c.id) AS qtd
              FROM cliente_grupo g
              LEFT JOIN cliente c ON c.idGrupoCliente = g.id
              GROUP BY g.id, g.descricao
              HAVING COUNT(c.id) > 0
              ORDER BY g.id";
      $res = $conn->query($query);
      ?>

      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Grupo</th>
            <th>Qtd. Clientes</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($r = $res->fetch_assoc()): ?>
              <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['grupo']) ?></td>
                <td><?= $r['qtd'] ?></td>
              </tr>
            <?php endwhile; ?>

          <?php else: ?>
            <tr>
              <td colspan="3">Nenhum grupo encontrado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

    </div>

  </div>
</body>

</html>
