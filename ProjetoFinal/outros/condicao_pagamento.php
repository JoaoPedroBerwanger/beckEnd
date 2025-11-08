<?php
$conn = new mysqli('localhost', 'root', '', 'vendas');

if ($conn->connect_error) {
    die("Conexão com banco falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado corretamente
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['produto_id'], $_POST['usuario_id'], $_POST['preco_produto'], $_POST['quantidade'], $_POST['total'])) {
    header('Location: vender.php');
    exit();
}

// Recebe os dados enviados
$produto_id = $_POST['produto_id'];
$usuario_id = $_POST['usuario_id'];
$preco_produto = $_POST['preco_produto'];
$quantidade = $_POST['quantidade'];
$total = $_POST['total'];

// Busca o nome do produto
$produto_query = $conn->query("SELECT nome FROM produto WHERE id = $produto_id");
if ($produto_query && $produto = $produto_query->fetch_assoc()) {
    $nome_produto = $produto['nome'];
} else {
    die("Erro ao buscar o nome do produto.");
}

// Busca o nome do usuário
$usuario_query = $conn->query("SELECT nome FROM usuario WHERE id = $usuario_id");
if ($usuario_query && $usuario = $usuario_query->fetch_assoc()) {
    $nome_usuario = $usuario['nome'];
} else {
    die("Erro ao buscar o nome do usuário.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condição de Pagamento</title>
</head>
<body>
    <h2>Condição de Pagamento</h2>
    <p><strong>Produto:</strong> <?php echo htmlspecialchars($nome_produto); ?></p>
    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($nome_usuario); ?></p>
    <p><strong>Preço Unitário:</strong> R$ <?php echo number_format($preco_produto, 2, ',', '.'); ?></p>
    <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($quantidade); ?></p>
    <p><strong>Total:</strong> R$ <?php echo number_format($total, 2, ',', '.'); ?></p>

    <form method="POST" action="salvar_venda.php">
        <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
        <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">
        <input type="hidden" name="preco_produto" value="<?php echo $preco_produto; ?>">
        <input type="hidden" name="quantidade" value="<?php echo $quantidade; ?>">
        <input type="hidden" name="total" value="<?php echo $total; ?>">

        <label for="condicao_pagamento">Condição de Pagamento:</label>
        <select name="condicao_pagamento" id="condicao_pagamento" required onchange="exibirParcelas()">
            <option value="">Selecione...</option>
            <option value="à vista">À vista</option>
            <option value="parcelado">Parcelado</option>
        </select>
        <br><br>

        <div id="opcao_parcelas" style="display: none;">
            <label for="parcelas">Número de Parcelas:</label>
            <input type="number" name="parcelas" id="parcelas" min="1" onchange="calcularParcelas()">
            <br><br>
            <div id="detalhes_parcelas"></div>
        </div>

        <button type="submit">Finalizar Venda</button>
    </form>

    <script>
        // Exibir campo de parcelas se for selecionado 'Parcelado'
        function exibirParcelas() {
            const condicao = document.getElementById('condicao_pagamento').value;
            const opcaoParcelas = document.getElementById('opcao_parcelas');
            opcaoParcelas.style.display = (condicao === 'parcelado') ? 'block' : 'none';
        }

        // Calcular e exibir o valor de cada parcela
        function calcularParcelas() {
            const total = <?php echo $total; ?>;
            const parcelas = parseInt(document.getElementById('parcelas').value) || 1;
            const valorParcela = (total / parcelas).toFixed(2);
            const detalhesParcelas = document.getElementById('detalhes_parcelas');

            if (parcelas > 0) {
                let html = `<p><strong>Valor de Cada Parcela:</strong> R$ ${valorParcela}</p>`;
                html += '<ul>';
                for (let i = 1; i <= parcelas; i++) {
                    const vencimento = new Date();
                    vencimento.setMonth(vencimento.getMonth() + i);
                    const vencimentoFormatado = vencimento.toLocaleDateString('pt-BR');
                    html += `<li>Parcela ${i}: R$ ${valorParcela} - Vencimento: ${vencimentoFormatado}</li>`;
                }
                html += '</ul>';
                detalhesParcelas.innerHTML = html;
            } else {
                detalhesParcelas.innerHTML = '';
            }
        }
    </script>
</body>
</html>
