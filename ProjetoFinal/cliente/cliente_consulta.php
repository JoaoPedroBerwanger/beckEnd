<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

require_once '../funcoes.php';

$modo = $_GET['modo'] ?? 'lista';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$select = $conn->query("SELECT c.*, g.descricao AS grupo 
  FROM cliente c
  LEFT JOIN cliente_grupo g ON g.id = c.idGrupoCliente
  ORDER BY c.id");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Clientes</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div>Clientes</div>
      <div><a class="button" href="../home.php">Voltar</a></div>
    </div>

    <div id="ok" class="notice" style="display:none;"></div>
    <div id="erro" class="error" style="display:none;"></div>
    <a class="button" href="cliente_form.php?modo=novo">Novo Cliente</a>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>CPF/CNPJ</th>
          <th>Endereço</th>
          <th>Número</th>
          <th>Bairro</th>
          <th>CEP</th>
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
              <td><?= htmlspecialchars($r['rua']) ?></td>
              <td><?= $r['numero'] ?></td>
              <td><?= htmlspecialchars($r['bairro']) ?></td>
              <td><?= htmlspecialchars($r['cep']) ?></td>
              <td><?= htmlspecialchars($r['email']) ?></td>
              <td><?= htmlspecialchars($r['grupo']) ?></td>
              <td><?= $r['idnAtivo'] ? 'Sim' : 'Não' ?></td>

              <td>
                <a class="button" href="cliente_form.php?modo=editar&id=<?= $r['id'] ?>">Editar</a>
                <form method="POST" action="../funcoes.php" style="display:inline;">
                  <input type="hidden" name="acao" value="delCliente">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <button type="submit" onclick="return confirm('Excluir registro?')" class="button">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>

        <?php else: ?>
          <tr>
            <td colspan="11">Nenhum registro encontrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
  <script src="../assets/js/alertas.js"></script>
</body>

</html>