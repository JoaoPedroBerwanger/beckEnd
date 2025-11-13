<?php
require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

$modo = $_GET['modo'] ?? 'lista';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$select = $conn->query("SELECT id, nome, cpfCnpj, email, idGrupoCliente, idnAtivo FROM cliente ORDER BY id");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Clientes</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
  <script src="assets/js/alertas.js"></script>
</head>

<body>
  <div class="wrap">

    <div class="header">
      <div>Clientes</div>
      <div><a class="button" href="home.php">Voltar</a></div>
    </div>

    <div class="form-card">
      <a class="button" href="cliente_form.php?modo=novo">Novo Cliente</a>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>CPF/CNPJ</th>
          <th>Email</th>
          <th>Grupo</th>
          <th>Ativo</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
        <?php if ($select && $select->num_rows > 0): ?>
          <?php while ($r = $select->fetch_assoc()): ?>
            <tr>
              <td><?= $r['id'] ?></td>
              <td><?= htmlspecialchars($r['nome']) ?></td>
              <td><?= htmlspecialchars($r['cpfCnpj']) ?></td>
              <td><?= htmlspecialchars($r['email']) ?></td>
              <td><?= htmlspecialchars($r['idGrupoCliente']) ?></td>
              <td><?= $r['idnAtivo'] ? 'Sim' : 'Não' ?></td>

              <td>
                <a href="cliente_form.php?modo=editar&id=<?= $r['id'] ?>">Editar</a>
                <form method="POST" action="funcoes.php" style="display:inline;">
                  <input type="hidden" name="acao" value="delCliente">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <button type="submit" onclick="return confirm('Excluir registro?')" class="link-btn">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>

        <?php else: ?>
          <tr><td colspan="7">Nenhum registro encontrado.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
