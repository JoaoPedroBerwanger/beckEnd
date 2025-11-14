<?php

require_once '../funcoes.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

// inicializa a lista com os itens da venda na sessão
if (!isset($_SESSION['produtosVenda'])) {
  $_SESSION['produtosVenda'] = [];
}

// trata inclusão / remoção de produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // adicionar produto
  if (isset($_POST['add_produto'])) {
    $idProduto   = intval($_POST['idProduto'] ?? 0);
    $quantidade  = floatval($_POST['quantidade'] ?? 0);
    $precoVenda  = floatval($_POST['precoVenda'] ?? 0);
    $desconto    = floatval($_POST['desconto'] ?? 0);

    if ($idProduto > 0 && $quantidade > 0 && $precoVenda > 0) {

      // busca produto
      $qProd = $conn->query("SELECT descricao, precoCusto FROM produto WHERE id = $idProduto");
      $prod  = $qProd && $qProd->num_rows ? $qProd->fetch_assoc() : null;

      if ($prod) {
        $precoCusto = floatval($prod['precoCusto'] ?? 0);
        $totalproduto  = ($quantidade * $precoVenda) - $desconto;

        $_SESSION['produtosVenda'][] = [
          'idProduto' => $idProduto,
          'descricao' => $prod['descricao'],
          'quantidade' => $quantidade,
          'precoVenda' => $precoVenda,
          'precoCusto' => $precoCusto,
          'desconto' => $desconto,
          'total' => $totalproduto
        ];
      }
    }
  }

  // remover produto (por índice)
  if (isset($_POST['remover_produto'], $_POST['index'])) {
    $idx = intval($_POST['index']);
    if (isset($_SESSION['produtosVenda'][$idx])) {
      unset($_SESSION['produtosVenda'][$idx]);
      $_SESSION['produtosVenda'] = array_values($_SESSION['produtosVenda']); // reorganiza índices
    }
  }
}

// carrega combos básicos
$clientes   = $conn->query("SELECT id, nome FROM cliente WHERE idnAtivo = 1 ORDER BY nome");
$condicoes  = $conn->query("SELECT id, descricao FROM condicao_pagamento WHERE idnAtivo = 1 ORDER BY descricao");
$formaspag  = $conn->query("SELECT id, descricao FROM forma_pagamento WHERE idnAtivo = 1 ORDER BY descricao");
$produtos   = $conn->query("SELECT id, descricao, precoVenda FROM produto WHERE idnAtivo = 1 ORDER BY descricao");

// calcula total da venda a partir dos itens
$totalItens = 0;
foreach ($_SESSION['produtosVenda'] as $it) {
  $totalItens += $it['total'];
}

// desconto global (se já enviado numa tentativa anterior, mantemos)
$descontoGlobal = isset($_POST['descontoGlobal']) ? floatval($_POST['descontoGlobal']) : 0;
$totalComDesconto = $totalItens - $descontoGlobal;
if ($totalComDesconto < 0) $totalComDesconto = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Nova Venda</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
  <div class="wrap">

    <div class="header">
      <div>Nova Venda</div>
      <a class="button" href="../home.php">Voltar</a>
    </div>

    <div class="form-card">
      <form method="POST" action="venda_form.php">

        <h3>Dados da Venda</h3>

        <label>Cliente</label>
        <select name="idCliente" required>
          <option value="">Selecione</option>
          <?php if ($clientes): while($c = $clientes->fetch_assoc()): ?>
            <option value="<?= $c['id']; ?>" <?= (($_POST['idCliente'] ?? '') == $c['id']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($c['nome']); ?>
            </option>
          <?php endwhile; endif; ?>
        </select>

        <label>Condição de Pagamento</label>
        <select name="idCondicaoPagamento" required>
          <option value="">Selecione</option>
          <?php if ($condicoes): while($c = $condicoes->fetch_assoc()): ?>
            <option value="<?= $c['id']; ?>" <?= (($_POST['idCondicaoPagamento'] ?? '') == $c['id']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($c['descricao']); ?>
            </option>
          <?php endwhile; endif; ?>
        </select>

        <label>Forma de Pagamento</label>
        <select name="idFormaPagamento" required>
          <option value="">Selecione</option>
          <?php if ($formaspag): while($f = $formaspag->fetch_assoc()): ?>
            <option value="<?= $f['id']; ?>" <?= (($_POST['idFormaPagamento'] ?? '') == $f['id']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($f['descricao']); ?>
            </option>
          <?php endwhile; endif; ?>
        </select>

        <hr>

        <h3>Adicionar Produto</h3>

        <label>Produto</label>
        <select name="idProduto" required>
          <option value="">Selecione</option>
          <?php if ($produtos): while($p = $produtos->fetch_assoc()): ?>
            <option value="<?= $p['id']; ?>">
              <?= htmlspecialchars($p['descricao']); ?>
            </option>
          <?php endwhile; endif; ?>
        </select>

        <label>Quantidade</label>
        <input type="number" name="quantidade" min="1" step="0.01" value="1">

        <label>Preço (pode editar)</label>
        <input type="number" name="precoVenda" min="0" step="0.01">

        <label>Desconto do produto (R$)</label>
        <input type="number" name="desconto" min="0" step="0.01" value="0">

        <button type="submit" name="add_produto" style="margin-top:10px">Adicionar produto</button>

        <hr>

        <h3>Itens da Venda</h3>

        <table class="table">
          <thead>
            <tr>
              <th>Produto</th>
              <th>Qtd</th>
              <th>Preço</th>
              <th>Desconto (R$)</th>
              <th>Total</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($_SESSION['produtosVenda'])): ?>
              <?php foreach ($_SESSION['produtosVenda'] as $idx => $it): ?>
                <tr>
                  <td><?= htmlspecialchars($it['descricao']); ?></td>
                  <td><?= $it['quantidade']; ?></td>
                  <td>R$ <?= number_format($it['precoVenda'], 2, ',', '.'); ?></td>
                  <td>R$ <?= number_format($it['desconto'], 2, ',', '.'); ?></td>
                  <td>R$ <?= number_format($it['total'], 2, ',', '.'); ?></td>
                  <td>
                    <button type="submit" name="remover_produto" value="1" onclick="return confirm('Remover produto?')">
                      Remover
                    </button>
                    <input type="hidden" name="index" value="<?= $idx; ?>">
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6">Nenhum produto adicionado ainda.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>

        <hr>

        <h3>Totalização</h3>

        <p><strong>Total dos Itens:</strong> R$ <?= number_format($totalItens, 2, ',', '.'); ?></p>

        <label>Desconto Global (R$)</label>
        <input type="number" name="descontoGlobal" min="0" step="0.01" 
               value="<?= htmlspecialchars((string)$descontoGlobal); ?>">

        <p><strong>Total da Venda:</strong> R$ <?= number_format($totalComDesconto, 2, ',', '.'); ?></p>

        <!-- IMPORTANTE: este botão vai para funcoes.php, com os dados do cabeçalho e totais -->
        <button type="submit"
                formaction="funcoes.php"
                name="acao"
                value="finalizarVenda"
                style="margin-top:10px">
          Finalizar Venda
        </button>

      </form>
    </div>

  </div>
</body>
</html>
