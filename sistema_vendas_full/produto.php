<?php
require_once 'conexao.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

$modo = $_GET['modo'] ?? 'lista';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// === INSERÇÃO / EDIÇÃO ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
  $idPost = intval($_POST['id'] ?? 0);
  $descricao = trim($_POST['descricao'] ?? '');
  $precoVenda = floatval($_POST['precoVenda'] ?? 0);
  $precoCusto = floatval($_POST['precoCusto'] ?? 0);
  $idMarcaProduto = !empty($_POST['idMarcaProduto']) ? intval($_POST['idMarcaProduto']) : null;
  $idGrupoProduto = !empty($_POST['idGrupoProduto']) ? intval($_POST['idGrupoProduto']) : null;
  $idnBaixa = isset($_POST['idnBaixa']) ? 1 : 0;

  if ($idPost > 0) {
    // Atualizar produto existente
    $sql = "UPDATE produto 
            SET descricao = ?, precoVenda = ?, precoCusto = ?, idMarcaProduto = ?, idGrupoProduto = ?, idnBaixa = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddiiii", $descricao, $precoVenda, $precoCusto, $idMarcaProduto, $idGrupoProduto, $idnBaixa, $idPost);
    $ok = $stmt->execute();
    echo $ok ? "<div class='notice'>Registro atualizado com sucesso.</div>" :
      "<div class='error'>Erro ao atualizar: {$conn->error}</div>";
  } else {
    // Inserir novo produto
    $sql = "INSERT INTO produto (descricao, precoVenda, precoCusto, idMarcaProduto, idGrupoProduto, idnBaixa)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddiii", $descricao, $precoVenda, $precoCusto, $idMarcaProduto, $idGrupoProduto, $idnBaixa);
    $ok = $stmt->execute();
    echo $ok ? "<div class='notice'>Registro inserido com sucesso.</div>" :
      "<div class='error'>Erro ao inserir: {$conn->error}</div>";
  }

  $modo = 'lista';
}

// === EXCLUSÃO ===
if ($modo === 'excluir' && $id > 0) {
  $conn->query("DELETE FROM produto WHERE id = $id");
  echo "<div class='notice'>Registro excluído.</div>";
  $modo = 'lista';
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Produtos</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Produtos</div>
      <div><a class="btn-link" href="home.php">⟵ Voltar</a></div>
    </div>

    <?php if ($modo === 'novo' || ($modo === 'editar' && $id > 0)): ?>
      <?php
      $row = ['descricao' => '', 'precoVenda' => '', 'precoCusto' => '', 'idMarcaProduto' => '', 'idGrupoProduto' => '', 'idnBaixa' => 0];
      if ($modo === 'editar') {
        $q = $conn->query("SELECT * FROM produto WHERE id = $id");
        $row = $q->fetch_assoc();
      }
      ?>
      <div class="form-card">
        <form method="POST">
          <?php if ($modo === 'editar'): ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php endif; ?>

          <label>Descrição</label>
          <input type="text" name="descricao" value="<?php echo htmlspecialchars($row['descricao']); ?>" required>

          <label>Preço de Venda</label>
          <input type="number" step="0.01" name="precoVenda" value="<?php echo htmlspecialchars($row['precoVenda']); ?>">

          <label>Preço de Custo</label>
          <input type="number" step="0.01" name="precoCusto" value="<?php echo htmlspecialchars($row['precoCusto']); ?>">

          <label>Marca:</label>
          <select name="idMarcaProduto">
            <option value="">-- Selecione --</option>
            <?php
            $resMarca = $conn->query("SELECT id, descricao FROM marca ORDER BY descricao");
            while ($m = $resMarca->fetch_assoc()) {
              $sel = ($row['idMarcaProduto'] == $m['id']) ? "selected" : "";
              echo "<option value='{$m['id']}' $sel>{$m['descricao']}</option>";
            }
            ?>
          </select>

          <label>Grupo de Produto:</label>
          <select name="idGrupoProduto">
            <option value="">-- Selecione --</option>
            <?php
            $resGrupo = $conn->query("SELECT id, descricao FROM produto_grupo ORDER BY descricao");
            while ($g = $resGrupo->fetch_assoc()) {
              $sel = ($row['idGrupoProduto'] == $g['id']) ? "selected" : "";
              echo "<option value='{$g['id']}' $sel>{$g['descricao']}</option>";
            }
            ?>
          </select>

          <label>Ativo para baixa:</label>
          <input type="checkbox" name="idnBaixa" value="1" <?php echo ($row['idnBaixa'] == 1) ? 'checked' : ''; ?>>

          <button type="submit" name="salvar">Salvar</button>
          <a class="btn-link" href="?">Cancelar</a>
        </form>
      </div>
    <?php endif; ?>

    <?php if ($modo === 'lista'): ?>
      <div class="form-card">
        <a class="btn-link" href="?modo=novo">+ Novo</a>
      </div>
      <?php
      $res = $conn->query("
        SELECT p.id, p.descricao, m.descricao AS marca, g.descricao AS grupo,
               p.precoVenda, p.precoCusto, p.idnBaixa
        FROM produto p
        LEFT JOIN marca m ON p.idMarcaProduto = m.id
        LEFT JOIN produto_grupo g ON p.idGrupoProduto = g.id
        ORDER BY p.descricao
      ");
      ?>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Marca</th>
            <th>Grupo</th>
            <th>Preço Venda</th>
            <th>Preço Custo</th>
            <th>Ativo Baixa</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($r = $res->fetch_assoc()): ?>
              <tr>
                <td><?php echo $r['id']; ?></td>
                <td><?php echo htmlspecialchars($r['descricao']); ?></td>
                <td><?php echo htmlspecialchars($r['marca'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($r['grupo'] ?? '-'); ?></td>
                <td><?php echo number_format($r['precoVenda'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($r['precoCusto'], 2, ',', '.'); ?></td>
                <td><?php echo $r['idnBaixa'] ? 'Sim' : 'Não'; ?></td>
                <td>
                  <a href="?modo=editar&id=<?php echo $r['id']; ?>">Editar</a> |
                  <a href="?modo=excluir&id=<?php echo $r['id']; ?>" onclick="return confirm('Excluir registro?')">Excluir</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8">Nenhum registro encontrado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <p><a class="back" href="home.php">⟵ Voltar ao Menu</a></p>
  </div>
</body>

</html>