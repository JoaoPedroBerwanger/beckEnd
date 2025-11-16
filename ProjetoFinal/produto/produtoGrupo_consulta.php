<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

require_once '../funcoes.php';

$grupos = $conn->query("SELECT * FROM produto_grupo ORDER BY descricao");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Grupos de Produto</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <script src="assets/js/alertas.js"></script>
</head>

<body>
  <div class="wrap">
    <div class="wrap">
      <div class="header">
        <div>Grupo de Produtos</div>
        <div><a class="button" href="../home.php">Voltar</a></div>
      </div>

      <a class="button" href="produtoGrupo_form.php?modo=novo">Novo Grupo</a>

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
          <?php if ($grupos && $grupos->num_rows): ?>
            <?php while ($g = $grupos->fetch_assoc()): ?>
              <tr>
                <td><?= $g['id'] ?></td>
                <td><?= htmlspecialchars($g['descricao']) ?></td>
                <td><?= $g['idnAtivo'] ?></td>
                <td>
                  <a href="produtoGrupo_form.php?modo=editar&id=<?= $g['id'] ?>">Editar</a>
                  <form method="POST" action="../funcoes.php" style="display:inline">
                    <input type="hidden" name="acao" value="delGrupoProduto">
                    <input type="hidden" name="id" value="<?= $g['id'] ?>">
                    <button type="submit" onclick="return confirm('Excluir permanentemente?')">Excluir</button>
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
</body>

</html>