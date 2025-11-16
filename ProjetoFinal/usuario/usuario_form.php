<?php
require_once '../funcoes.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$row = ['nome' => '', 'login' => '', 'idnAtivo' => 1];
$modo = $id > 0 ? 'editar' : 'novo';

if ($id > 0) {
  $q = $conn->query("SELECT * FROM usuario WHERE id = $id");
  $row = $q->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title><?= $modo === 'editar' ? 'Editar Usuário' : 'Novo Usuário' ?></title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <script src="../assets/js/alertas.js"></script>
</head>

<body class="bg">
  <div class="form-card">
    <div id="ok" class="notice" style="display:none;"></div>
    <div id="erro" class="error" style="display:none;"></div>
    <h2><?= $modo === 'editar' ? 'Editar Usuário' : 'Novo Usuário' ?></h2>

    <form method="POST" action="../funcoes.php">
      <?php if ($modo === 'editar'): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
      <?php endif; ?>

      <label>Nome</label>
      <input type="text" name="nome" value="<?= htmlspecialchars($row['nome']) ?>" required>

      <label>Login</label>
      <input type="text" name="login" value="<?= htmlspecialchars($row['login']) ?>" required>

      <label>Senha</label>
      <input type="password" name="senha" placeholder="<?= $modo === 'editar' ? 'Deixe em branco para manter' : '' ?>">

      <?php if ($modo === 'editar'): ?>
        <label>Ativo</label>
        <select name="idnAtivo">
          <option value="1" <?= $row['idnAtivo'] ? 'selected' : '' ?>>Sim</option>
          <option value="0" <?= !$row['idnAtivo'] ? 'selected' : '' ?>>Não</option>
        </select>
      <?php endif; ?>

      <div class="actions">
        <input type="hidden" name="acao" value="<?= $modo === 'editar' ? 'editarUsuario' : 'addUsuario' ?>">
        <button type="submit" name="salvar">Salvar</button>
        <a class="button" href="usuario_consulta.php">Cancelar</a>
      </div>
    </form>
  </div>
</body>

</html>