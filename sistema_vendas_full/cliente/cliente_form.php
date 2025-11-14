<?php

require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.html");
  exit;
}

$modo = $_GET['modo'] ?? 'novo';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Valores padrões para novo cadastro
$cliente = [
  'id' => 0,
  'nome' => '',
  'cpfCnpj' => '',
  'email' => '',
  'idGrupoCliente' => '',
  'idnAtivo' => 1
];

if ($modo === 'editar' && $id > 0) {
  $query = $conn->query("SELECT * FROM cliente WHERE id = $id");
  if ($query && $query->num_rows > 0) {
    $cliente = $query->fetch_assoc();
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?= $modo === 'editar' ? 'Editar Cliente' : 'Novo Cliente' ?></title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <script src="../assets/js/alertas.js"></script>
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div><?= $modo === 'editar' ? 'Editar Cliente' : 'Novo Cliente' ?></div>
      <a class="button" href="cliente_consulta.php">Voltar</a>
    </div>

    <div class="form-card">

      <form method="POST" action="../funcoes.php">

        <input type="hidden" name="acao" 
               value="<?= $modo === 'editar' ? 'editarCliente' : 'addCliente' ?>">

        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

        <label>Nome</label>
        <input type="text" name="nome" required
               value="<?= htmlspecialchars($cliente['nome']) ?>">

        <label>CPF/CNPJ</label>
        <input type="text" name="cpfCnpj" required
               value="<?= htmlspecialchars($cliente['cpfCnpj']) ?>">

        <label>Email</label>
        <input type="email" name="email" required
               value="<?= htmlspecialchars($cliente['email']) ?>">

        <label>Grupo (ID)</label>
        <input type="number" name="idGrupoCliente"
               value="<?= htmlspecialchars($cliente['idGrupoCliente']) ?>">

        <?php if ($modo === 'editar'): ?>
          <label>Ativo</label>
          <select name="idnAtivo">
            <option value="1" <?= $cliente['idnAtivo'] ? 'selected' : '' ?>>Sim</option>
            <option value="0" <?= !$cliente['idnAtivo'] ? 'selected' : '' ?>>Não</option>
          </select>
        <?php endif; ?>

        <div class="actions">
          <button type="submit">Salvar</button>
          <a class="button" href="cliente_consulta.php">Cancelar</a>
        </div>

      </form>

    </div>

  </div>
</body>
</html>
