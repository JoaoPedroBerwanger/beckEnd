<?php
require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

$regs = $conn->query("SELECT * FROM condicao_pagamento ORDER BY descricao");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Condições de Pagamento</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div>Condições de Pagamento</div>
      <a class="button" href="home.php">Voltar</a>
    </div>

    <div class="form-card">
      <a class="button" href="condicaoPagamento_form.php?modo=novo">+ Nova Condição</a>
    </div>

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
        <?php if ($regs && $regs->num_rows > 0): ?>
          <?php while($r = $regs->fetch_assoc()): ?>
            <tr>
              <td><?= $r['id'] ?></td>
              <td><?= htmlspecialchars($r['descricao']) ?></td>
              <td><?= $r['idnAtivo'] ? 'Sim' : 'Não' ?></td>
              <td>
                <a href="condicaoPagamento_form.php?modo=editar&id=<?= $r['id'] ?>">Editar</a>
                |
                <form method="POST" action="funcoes.php" style="display:inline;">
                  <input type="hidden" name="acao" value="delCondicaoPagamento">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <button type="submit" onclick="return confirm('Excluir registro?')" class="link-btn">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="4">Nenhuma condição cadastrada.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
