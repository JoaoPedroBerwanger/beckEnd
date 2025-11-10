<?php require_once 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['produto_id'], $_POST['usuario_id'], $_POST['preco_produto'], $_POST['quantidade'], $_POST['total'])) {
  header('Location: vender.php');
  exit();
}
$produto_id = intval($_POST['produto_id']);
$usuario_id = intval($_POST['usuario_id']);
$preco = floatval($_POST['preco_produto']);
$qtd = intval($_POST['quantidade']);
$total = floatval($_POST['total']);
$produto_nome = ($conn->query("SELECT descricao FROM produto WHERE id=$produto_id")->fetch_assoc())['descricao'] ?? '-';
$usuario_nome = ($conn->query("SELECT nome FROM usuario WHERE id=$usuario_id")->fetch_assoc())['nome'] ?? '-';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Condição de Pagamento</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body class="bg">
  <div class="card" style="width:720px;max-width:92vw">
    <h2>Condição de Pagamento</h2>
    <p><strong>Produto:</strong> <?php echo htmlspecialchars($produto_nome); ?></p>
    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($usuario_nome); ?></p>
    <p><strong>Preço Unitário:</strong> R$ <?php echo number_format($preco, 2, ',', '.'); ?></p>
    <p><strong>Quantidade:</strong> <?php echo $qtd; ?></p>
    <p><strong>Total:</strong> R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
    <form method="POST" action="salvar_venda.php">
      <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
      <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">
      <input type="hidden" name="preco_produto" value="<?php echo $preco; ?>">
      <input type="hidden" name="quantidade" value="<?php echo $qtd; ?>">
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <label>Condição de Pagamento</label>
      <select name="condicao_pagamento" id="condicao_pagamento" required onchange="exibirParcelas()">
        <option value="">Selecione</option>
        <option value="à vista">À vista</option>
        <option value="parcelado">Parcelado</option>
      </select>
      <div id="opcao_parcelas" style="display:none;margin-top:10px">
        <label>Número de Parcelas</label>
        <input type="number" name="parcelas" id="parcelas" min="1" onchange="calcularParcelas()">
        <div id="detalhes_parcelas"></div>
      </div>
      <button type="submit" style="margin-top:10px">Finalizar Venda</button>
    </form>
  </div>
  <script>
    function exibirParcelas() {
      const c = document.getElementById('condicao_pagamento').value;
      document.getElementById('opcao_parcelas').style.display = (c === 'parcelado') ? 'block' : 'none';
    }

    function calcularParcelas() {
      const total = <?php echo $total; ?>;
      const n = parseInt(document.getElementById('parcelas').value) || 1;
      const v = (total / n).toFixed(2);
      document.getElementById('detalhes_parcelas').innerHTML = n > 0 ? `<p>Valor por parcela: R$ ${v}</p>` : '';
    }
  </script>
</body>

</html>