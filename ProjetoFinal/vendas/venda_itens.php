<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit;
}

require_once '../funcoes.php';

$idVenda = intval($_GET['id'] ?? 0);

if ($idVenda <= 0) {
    die("<p style='padding:20px'>ID da venda inválido.</p>");
}

// Consulta a venda
$selectVenda = "
    SELECT v.*, 
           c.nome AS cliente,
           cp.descricao AS condicao,
           fp.descricao AS forma
    FROM vendas v
    LEFT JOIN cliente c ON c.id = v.idCliente
    LEFT JOIN condicao_pagamento cp ON cp.id = v.idCondicaoPagamento
    LEFT JOIN forma_pagamento fp ON fp.id = v.idFormaPagamento
    WHERE v.id = $idVenda
";

$resVenda = $conn->query($selectVenda);
$venda = ($resVenda && $resVenda->num_rows > 0) ? $resVenda->fetch_assoc() : null;

if (!$venda) {
    die("<p style='padding:20px'>Venda não encontrada.</p>");
}

// Busca os itens da venda
$selectProdutos = "
    SELECT vi.*, p.descricao 
    FROM venda_produtos vi
    LEFT JOIN produto p ON p.id = vi.idProduto
    WHERE vi.idVenda = $idVenda
";

$resProd = $conn->query($selectProdutos);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Itens da Venda <?= $idVenda ?></title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
    <div class="wrap">

        <div class="header">
            <div>Itens da Venda <?= $idVenda ?></div>
            <div style="display:flex; gap:10px;">
                <a class="button" onclick="window.print()">Imprimir</a>
                <a class="button" href="venda_consulta.php">Voltar</a>
            </div>
        </div>


        <div class="form-card print-area">

            <h3>Informações da Venda</h3>

            <p><strong>Cliente:</strong> <?= htmlspecialchars($venda['cliente']) ?></p>
            <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($venda['dataVenda'])) ?></p>
            <p><strong>Condição Pagamento:</strong> <?= htmlspecialchars($venda['condicao']) ?></p>
            <p><strong>Forma Pagamento:</strong> <?= htmlspecialchars($venda['forma']) ?></p>
            <p><strong>Total da Venda:</strong> R$ <?= number_format($venda['totalVenda'], 2, ',', '.') ?></p>

            <hr>

            <h3>Itens</h3>

            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Preço</th>
                        <th>Desconto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resProd && $resProd->num_rows > 0): ?>
                        <?php while ($it = $resProd->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($it['descricao']) ?></td>
                                <td><?= $it['quantidade'] ?></td>
                                <td>R$ <?= number_format($it['precoVenda'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($it['desconto'], 2, ',', '.') ?></td>
                                <td>
                                    R$ <?= number_format(($it['quantidade'] * $it['precoVenda']) - $it['desconto'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Nenhum item encontrado nesta venda.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>

    </div>
</body>

</html>