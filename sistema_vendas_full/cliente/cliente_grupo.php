<?php
require_once 'funcoes.php';

// Protege o acesso
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
  <title>Grupos de Parceiros</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
  <script src="assets/js/alertas.js"></script>
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Grupos de Parceiros</div>
      <div><a class="button" href="../home.php">⟵ Voltar</a></div>
    </div>

    <?php if ($modo === 'novo' || ($modo === 'editar' && $id > 0)): ?>
      <?php
      $row = ['descricao' => '', 'idnAtivo' => 1];
      if ($modo === 'editar') {
        $q = $conn->query("SELECT * FROM cliente_grupo WHERE id = $id");
        $row = $q->fetch_assoc();
      }
      ?>

      <div class="form-card">
        <form method="POST" action="funcoes.php">
          <input type="hidden" name="acao" value="<?php echo $modo === 'editar' ? 'editarGrupoCliente' : 'addGrupoCliente'; ?>">
          <?php if ($modo === 'editar'): ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php endif; ?>

          <label>Descrição</label>
          <input type="text" name="descricao" value="<?php echo htmlspecialchars($row['descricao']); ?>" required>

          <?php if ($modo === 'editar'): ?>
            <label>Ativo</label>
            <select name="idnAtivo">
              <option value="1" <?php echo $row['idnAtivo'] ? 'selected' : ''; ?>>Sim</option>
              <option value="0" <?php echo !$row['idnAtivo'] ? 'selected' : ''; ?>>Não</option>
            </select>
          <?php endif; ?>

          <div class="actions">
            <button type="button">Salvar</button>
            <a class="button" href="cliente_grupo.php">Cancelar</a>
          </div>
        </form>
      </div>
    <?php endif; ?>

    <?php if ($modo === 'lista'): ?>
      <div class="form-card">
        <a class="button" href="?modo=novo">+ Novo</a>
      </div>

      <?php $res = $conn->query("SELECT id, descricao, idnAtivo FROM cliente_grupo ORDER BY id"); ?>
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
          <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($r = $res->fetch_assoc()): ?>
              <tr>
                <td><?php echo $r['id']; ?></td>
                <td><?php echo htmlspecialchars($r['descricao']); ?></td>
                <td><?php echo $r['idnAtivo'] ? 'Sim' : 'Não'; ?></td>
                <td>
                  <a href="?modo=editar&id=<?php echo $r['id']; ?>">Editar</a> |
                  <form method="POST" action="funcoes.php" style="display:inline;">
                    <input type="hidden" name="acao" value="delGrupoCliente">
                    <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                    <button type="button" onclick="return confirm('Excluir registro?')" class="link-btn">Excluir</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4">Nenhum grupo encontrado.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>
</body>
</html>
