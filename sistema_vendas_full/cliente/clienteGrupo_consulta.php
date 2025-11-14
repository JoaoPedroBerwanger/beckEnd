<?php
require_once '../funcoes.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit;
}

$select = $conn->query("SELECT id, descricao, idnAtivo FROM cliente_grupo ORDER BY id");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Grupos de Parceiros</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <script src="assets/js/alertas.js"></script>
</head>

<body>
<div class="wrap">

  <div class="header">
    <div>Grupos de Parceiros</div>
    <div><a class="button" href="../home.php">Voltar</a></div>
  </div>

  <div class="form-card">
    <a class="button" href="clienteGrupo_form.php?modo=novo">Novo</a>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th>Ativo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>

    <?php if ($select && $select->num_rows > 0): ?>
      <?php while ($r = $select->fetch_assoc()): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['descricao']) ?></td>
          <td><?= $r['idnAtivo'] ? 'Sim' : 'Não' ?></td>

          <td>
            <a href="clienteGrupo_form.php?modo=editar&id=<?= $r['id'] ?>">Editar</a>
          </td>
        </tr>
      <?php endwhile; ?>

    <?php else: ?>
      <tr><td colspan="4">Nenhum grupo encontrado.</td></tr>
    <?php endif; ?>

    </tbody>
  </table>

</div>
</body>
</html>
