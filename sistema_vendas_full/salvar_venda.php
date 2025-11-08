<?php require_once 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['produto_id'], $_POST['usuario_id'], $_POST['preco_produto'], $_POST['quantidade'], $_POST['total'], $_POST['condicao_pagamento'])) {
  die("Erro ao enviar os dados.");
}
$produto_id = intval($_POST['produto_id']);
$usuario_id = intval($_POST['usuario_id']);
$preco = floatval($_POST['preco_produto']);
$qtd = intval($_POST['quantidade']);
$total = floatval($_POST['total']);
$cond = $_POST['condicao_pagamento'];
$numero = 1;
$q = $conn->query("SELECT IFNULL(MAX(numero),0)+1 AS proximo FROM vendas");
if ($q) {
  $r = $q->fetch_assoc();
  $numero = intval($r['proximo']);
}
$stmt = $conn->prepare("INSERT INTO vendas (numero, idCliente, idCondicaoPagamento, idFormaPagamento, totalVenda, dataVenda, idUsuario, idnCancelada) VALUES (?, 1, NULL, NULL, ?, NOW(), ?, 0)");
$stmt->bind_param("idi", $numero, $total, $usuario_id);
if (!$stmt->execute()) {
  die("Erro ao salvar venda: " . $conn->error);
}
$idVenda = $conn->insert_id;
$stmtItem = $conn->prepare("INSERT INTO venda_produtos (idVenda, idProduto, quantidade, desconto, precoVenda, precoCusto, total) VALUES (?, ?, ?, 0, ?, NULL, ?)");
$stmtItem->bind_param("iiidd", $idVenda, $produto_id, $qtd, $preco, $total);
if (!$stmtItem->execute()) {
  die("Erro ao salvar item: " . $conn->error);
}
if ($cond === 'parcelado' && isset($_POST['parcelas'])) {
  $parcelas = intval($_POST['parcelas']);
  if ($parcelas > 0) {
    $chk = $conn->query("SHOW TABLES LIKE 'parcela'");
    if ($chk && $chk->num_rows > 0) {
      $valor_parcela = $total / $parcelas;
      for ($i = 1; $i <= $parcelas; $i++) {
        $venc = new DateTime();
        $venc->modify("+$i month");
        $data = $venc->format('Y-m-d');
        $conn->query("INSERT INTO parcela (venda_id, numero_parcela, valor, vencimento) VALUES ($idVenda, $i, $valor_parcela, '$data')");
      }
    }
  }
}
header("Location: vendas.php");
exit;
