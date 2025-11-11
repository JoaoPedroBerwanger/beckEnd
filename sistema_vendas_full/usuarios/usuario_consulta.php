<?php

require_once '../funcoes.php';

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

$res = $conn->query("SELECT id, nome, login, idnAtivo FROM usuario ORDER BY id");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Usuários</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <script src="../assets/js/alertas.js"></script>
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Usuários</div>
      <div><a class="button" href="../home.php">⟵ Voltar</a></div>
    </div>

    <div class="form-card">
      <a class="button" href="usuario_form.php">+ Novo</a>
          <div id="erro" class="error" style="display: none"></div>
          <div id="ok" class="notice" style="display: none"></div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th><th>Nome</th><th>Login</th><th>Ativo</th><th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($res && $res->num_rows > 0): ?>
          <?php while ($r = $res->fetch_assoc()): ?>
            <tr>
              <td><?= $r['id'] ?></td>
              <td><?= htmlspecialchars($r['nome']) ?></td>
              <td><?= htmlspecialchars($r['login']) ?></td>
              <td><?= $r['idnAtivo'] ? 'Sim' : 'Não' ?></td>
              <td>
                <a class="button" href="usuario_form.php?id=<?= $r['id'] ?>">Editar</a> |
                <form method="POST" action="../funcoes.php" style="display:inline;">
                  <input type="hidden" name="acao" value="delUsuario">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <button type="button" onclick="return confirm('Excluir este usuário?')" class="link-btn">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5">Nenhum registro encontrado.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
