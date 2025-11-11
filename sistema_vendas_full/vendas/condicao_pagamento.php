<?php 
require_once 'funcoes.php'; 
?>

<!DOCTYPE html>
<html lang='pt-br'>

<head>
  <meta charset='UTF-8'>
  <title>Condições de Pagamento</title>
  <link rel='stylesheet' href='assets/css/estilo.css'>
</head>

<body>
  <div class='wrap'>
    <div class='header'>
      <div>Condições de Pagamento</div>
      <div><a class='button' href='home.php'>⟵ Voltar</a></div>
    </div>
    <?php
    $modo = isset($_GET['modo']) ? $_GET['modo'] : 'lista';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $idPost = isset($_POST['id']) ? intval($_POST['id']) : 0;
      if (isset($_POST['salvar'])) {
        $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
        $idnAtivo = isset($_POST['idnAtivo']) ? trim($_POST['idnAtivo']) : '';
        if ($idPost > 0) {
          $sql = "UPDATE condicao_pagamento SET descricao = ?, idnAtivo = ? WHERE id = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ssi", $descricao, $idnAtivo, $idPost);
          $ok = $stmt->execute();
          echo $ok ? "<div class='notice'>Registro atualizado com sucesso.</div>" : "<div class='error'>Erro ao atualizar: {$conn->error}</div>";
          $modo = 'lista';
        } else {
          $sql = "INSERT INTO condicao_pagamento (descricao, idnAtivo) VALUES (?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ss", $descricao, $idnAtivo);
          $ok = $stmt->execute();
          echo $ok ? "<div class='notice'>Registro inserido com sucesso.</div>" : "<div class='error'>Erro ao inserir: {$conn->error}</div>";
          $modo = 'lista';
        }
      }
    }
    if ($modo === 'excluir' && $id > 0) {
      $conn->query("DELETE FROM condicao_pagamento WHERE id = $id");
      echo "<div class='notice'>Registro excluído.</div>";
      $modo = 'lista';
    }
    ?>
    <?php if ($modo === 'novo' || ($modo === 'editar' && $id > 0)): ?>
      <?php if ($modo === 'editar') {
        $q = $conn->query("SELECT * FROM condicao_pagamento WHERE id = $id");
        $row = $q->fetch_assoc();
      } ?>
      <div class='form-card'>
        <form method='POST'>
          <?php if ($modo === 'editar'): ?><input type='hidden' name='id' value='<?php echo $id; ?>'><?php endif; ?>
          <label>Descrição</label><input type='text' name='descricao'
            value='<?php echo $modo === "editar" ? htmlspecialchars($row["descricao"] ?? "") : ""; ?>' required>
          <label>Ativo (1/0)</label><input type='text' name='idnAtivo'
            value='<?php echo $modo === "editar" ? htmlspecialchars($row["idnAtivo"] ?? "") : ""; ?>' required>
          <button type='button' name='salvar'>Salvar</button> <a class='button' href='?'>Cancelar</a>
        </form>
      </div>
    <?php endif; ?>
    <?php if ($modo === 'lista'): ?>
      <div class='form-card'><a class='button' href='?modo=novo'>+ Novo</a></div>
      <?php $res = $conn->query("SELECT id, descricao, idnAtivo FROM condicao_pagamento ORDER BY descricao"); ?>
      <table class='table'>
        <thead>
          <tr>
            <?php if ($res) {
              $fields = $res->fetch_fields();
              foreach ($fields as $f)
                echo '<th>' . htmlspecialchars($f->name) . '</th>';
            }
            echo '<th>Ações</th>'; ?>
          </tr>
        </thead>
        <tbody>
          <?php if ($res && $res->num_rows > 0):
            while ($r = $res->fetch_assoc()): ?>
              <tr>
                <?php foreach ($r as $val)
                  echo '<td>' . htmlspecialchars((string) $val) . '</td>'; ?>
                <?php $rid = intval($r['id'] ?? $r['id'] ?? 0); ?>
                <td><a href='?modo=editar&id=<?php echo $rid; ?>'>Editar</a> | <a href='?modo=excluir&id=<?php echo $rid; ?>'
                    onclick='return confirm("Excluir registro?")'>Excluir</a></td>
              </tr>
            <?php endwhile;
          else: ?>
            <tr>
              <td colspan='99'>Nenhum registro encontrado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    <?php endif; ?>
    <p><a class='button' href='home.php'>⟵ Voltar ao Menu</a></p>
  </div>
</body>

</html>