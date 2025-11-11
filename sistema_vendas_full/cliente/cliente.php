<?php
require_once 'funcoes.php';

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

$modo = $_GET['modo'] ?? 'lista';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
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
      <div><a class="button" href="../home.php">⟵ Voltar</a></div>
    </div>

    <?php if ($modo === 'novo' || ($modo === 'editar' && $id > 0)): ?>
      <?php
      $row = ['nome' => '', 'cpfCnpj' => '', 'email' => '', 'idGrupoCliente' => '', 'idnAtivo' => 1];
      if ($modo === 'editar') {
        $q = $conn->query("SELECT * FROM cliente WHERE id = $id");
        $row = $q->fetch_assoc();
      }
      ?>

      <div class="form-card">
        <form method="POST" action="funcoes.php">
          <input type="hidden" name="acao" value="<?php echo $modo === 'editar' ? 'editarCliente' : 'addCliente'; ?>">
          <?php if ($modo === 'editar'): ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php endif; ?>

          <label>Nome</label>
          <input type="text" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required>

          <label>CPF/CNPJ</label>
          <input type="text" name="cpfCnpj" value="<?php echo htmlspecialchars($row['cpfCnpj']); ?>" required>

          <label>Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

          <label>Grupo (id)</label>
          <input type="number" name="idGrupoCliente" value="<?php echo htmlspecialchars($row['idGrupoCliente']); ?>" required>

          <?php if ($modo === 'editar'): ?>
            <label>Ativo</label>
            <select name="idnAtivo">
              <option value="1" <?php echo $row['idnAtivo'] ? 'selected' : ''; ?>>Sim</option>
              <option value="0" <?php echo !$row['idnAtivo'] ? 'selected' : ''; ?>>Não</option>
            </select>
          <?php endif; ?>

          <div class="actions">
            <button type="button">Salvar</button>
            <a class="button" href="cliente.php">Cancelar</a>
          </div>
        </form>
      </div>
    <?php endif; ?>

    <?php if ($modo === 'lista'): ?>
      <div class="form-card">
        <a class="button" href="?modo=novo">+ Novo</a>
      </div>

      <?php $res = $conn->query("SELECT id, nome, cpfCnpj, email, idGrupoCliente, idnAtivo FROM cliente ORDER BY id"); ?>
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
          <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($r = $res->fetch_assoc()): ?>
              <tr>
                <td><?php echo $r['id']; ?></td>
                <td><?php echo htmlspecialchars($r['nome']); ?></td>
                <td><?php echo htmlspecialchars($r['cpfCnpj']); ?></td>
                <td><?php echo htmlspecialchars($r['email']); ?></td>
                <td><?php echo htmlspecialchars($r['idGrupoCliente']); ?></td>
                <td><?php echo $r['idnAtivo'] ? 'Sim' : 'Não'; ?></td>
                <td>
                  <a href="?modo=editar&id=<?php echo $r['id']; ?>">Editar</a> |
                  <form method="POST" action="funcoes.php" style="display:inline;">
                    <input type="hidden" name="acao" value="delCliente">
                    <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                    <button type="button" onclick="return confirm('Excluir registro?')" class="link-btn">Excluir</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7">Nenhum registro encontrado.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>
</body>
</html>
