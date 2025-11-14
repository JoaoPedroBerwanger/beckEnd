<?php
require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

$res = $conn->query("
  SELECT v.id, v.numero, v.dataVenda, v.totalVenda, v.idnCancelada,
         c.nome AS cliente,
         cp.descricao AS condicao,
         fp.descricao AS forma
  FROM vendas v
  LEFT JOIN cliente c ON c.id = v.idCliente
  LEFT JOIN condicao_pagamento cp ON cp.id = v.idCondicaoPagamento
  LEFT JOIN forma_pagamento fp ON fp.id = v.idFormaPagamento
  ORDER BY v.id DESC
");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Vendas</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">
    <div class="header">
      <div>Vendas</div>
      <a class="button" href="../home.php">Voltar</a>
    </div>

    <div class="form-card">
      <a class="button" href="venda_form.php">+ Nova Venda</a>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Nº</th>
          <th>Cliente</th>
          <th>Data</th>
          <th>Condição</th>
          <th>Forma</th>
          <th>Total</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
        <?php if ($res && $res->num_rows > 0): ?>
          <?php while ($v = $res->fetch_assoc()): ?>
            <tr>
              <td><?= $v['numero'] ?></td>
              <td><?= htmlspecialchars($v['cliente']) ?></td>
              <td><?= date('d/m/Y H:i', strtotime($v['dataVenda'])) ?></td>
              <td><?= htmlspecialchars($v['condicao']) ?></td>
              <td><?= htmlspecialchars($v['forma']) ?></td>
              <td>R$ <?= number_format($v['totalVenda'], 2, ',', '.') ?></td>

              <td>
                <?php if ($v['idnCancelada']): ?>
                  <span style="color:red;font-weight:bold;">Cancelada</span>
                <?php else: ?>
                  <span style="color:green;font-weight:bold;">Ativa</span>
                <?php endif; ?>
              </td>

              <td>

                <!-- Ver itens da venda -->
                <a href="venda_itens.php?id=<?= $v['id'] ?>">Itens</a>

                <?php if (!$v['idnCancelada']): ?>
                  |
                  <!-- Cancelar a venda -->
                  <form method="POST" action="funcoes.php" style="display:inline;">
                    <input type="hidden" name="acao" value="cancelarVenda">
                    <input type="hidden" name="id" value="<?= $v['id'] ?>">
                    <button type="submit"
                            class="link-btn"
                            onclick="return confirm('Cancelar esta venda? Isso não poderá ser desfeito!')">
                      Cancelar
                    </button>
                  </form>
                <?php endif; ?>

              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8">Nenhuma venda encontrada.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
