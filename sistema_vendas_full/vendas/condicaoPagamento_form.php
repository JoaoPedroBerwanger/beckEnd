<?php
require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

$modo = $_GET['modo'] ?? 'novo';
$id   = intval($_GET['id'] ?? 0);

$reg = [
  'id' => 0,
  'descricao' => '',
  'idnAtivo' => 1
];

if ($modo === 'editar' && $id > 0) {
  $q = $conn->query("SELECT * FROM condicao_pagamento WHERE id = $id");
  if ($q && $q->num_rows > 0) {
    $reg = $q->fetch_assoc();
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title><?= $modo === 'editar' ? 'Editar Condição' : 'Nova Condição' ?></title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div><?= $modo === 'editar' ? 'Editar Condição de Pagamento' : 'Nova Condição de Pagamento' ?></div>
      <a class="button" href="condicaoPagamento_consulta.php">Voltar</a>
    </div>

    <div class="form-card">
      <form method="POST" action="funcoes.php">

        <input type="hidden" name="acao" 
               value="<?= $modo === 'editar' ? 'editCondicaoPagamento' : 'addCondicaoPagamento' ?>">

        <input type="hidden" name="id" value="<?= $reg['id'] ?>">

        <label>Descrição</label>
        <input type="text" name="descricao" required value="<?= htmlspecialchars($reg['descricao']) ?>">

        <?php if ($modo === 'editar'): ?>
          <label>Ativo</label>
          <select name="idnAtivo">
            <option value="1" <?= $reg['idnAtivo'] ? 'selected' : '' ?>>Sim</option>
            <option value="0" <?= !$reg['idnAtivo'] ? 'selected' : '' ?>>Não</option>
          </select>
        <?php endif; ?>

        <button type="submit">Salvar</button>
        <a class="button" href="condicaoPagamento_consulta.php">Cancelar</a>
      </form>
    </div>

  </div>
</body>
</html>
