<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

require_once '../funcoes.php';

$select = $conn->query("SELECT id, descricao, idnAtivo FROM cliente_grupo ORDER BY id");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Grupos de Clientes</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
  <div class="wrap">

    <div class="header">
      <div>Grupos de Clientes</div>
      <div><a class="button" href="../home.php">Voltar</a></div>
    </div>

    <div id="ok" class="notice" style="display:none;"></div>
    <div id="erro" class="error" style="display:none;"></div>
    <a class="button" href="clienteGrupo_form.php?modo=novo">Novo Grupo</a>

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
                <a class="button" href="clienteGrupo_form.php?modo=editar&id=<?= $r['id'] ?>">Editar</a>
                <form action="../funcoes.php" method="POST" style="display:inline;">
                  <input type="hidden" name="acao" value="delGrupoCliente">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <button type="submit" class="button" onclick="return confirm('Deseja remover este grupo?')">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>

        <?php else: ?>
          <tr>
            <td colspan="4">Nenhum grupo encontrado.</td>
          </tr>
        <?php endif; ?>

      </tbody>
    </table>

  </div>
  <script src="../assets/js/alertas.js"></script>
</body>

</html>