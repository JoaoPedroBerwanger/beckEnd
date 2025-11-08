<?php require_once 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Relatório: Clientes por Grupo</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Relatório: Clientes por Grupo</div>
      <div><a class="btn-link" href="home.php">⟵ Voltar</a></div>
    </div>
    <?php
    $sql = "SELECT g.id, g.descricao AS grupo, COUNT(c.id) AS qtd
            FROM cliente_grupo g
            LEFT JOIN cliente c ON c.idGrupoCliente = g.id
            GROUP BY g.id, g.descricao
            ORDER BY g.descricao";
    $res = $conn->query($sql);
    echo "<table class='table'><thead><tr><th>ID</th><th>Grupo</th><th>Qtd. Clientes</th></tr></thead><tbody>";
    if ($res && $res->num_rows > 0) {
      while ($r = $res->fetch_assoc()) {
        echo "<tr><td>{$r['id']}</td><td>" . htmlspecialchars($r['grupo']) . "</td><td>{$r['qtd']}</td></tr>";
      }
    } else {
      echo "<tr><td colspan='3'>Nenhum grupo encontrado.</td></tr>";
    }
    echo "</tbody></table>";
    ?>
    <p><a class="back" href="home.php">⟵ Voltar ao Menu</a></p>
  </div>
</body>

</html>