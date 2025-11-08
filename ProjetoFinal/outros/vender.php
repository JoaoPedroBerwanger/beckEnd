<?php
$conn = new mysqli('localhost', 'root', '', 'vendas');

if ($conn->connect_error) {
    die("Conexão com banco falhou: " . $conn->connect_error);
}

// Busca os produtos
$produtos = $conn->query("SELECT id, nome, preco FROM produto");
if (!$produtos) {
    die("Erro ao buscar produtos: " . $conn->error);
}

// Busca os usuários
$usuarios = $conn->query("SELECT id, nome FROM usuario");
if (!$usuarios) {
    die("Erro ao buscar usuários: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Venda</title>
</head>
<body>
    <h2>Realizar Venda</h2>
    <form method="POST" action="condicao_pagamento.php">
        <label for="usuario_id">Usuário:</label>
        <select name="usuario_id" id="usuario_id" required>
            <option value="">Selecione um usuário</option>
            <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nome']; ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>

        <label for="produto_id">Produto:</label>
        <select name="produto_id" id="produto_id" required onchange="atualizarPreco()">
            <option value="">Selecione um produto</option>
            <?php while ($produto = $produtos->fetch_assoc()): ?>
                <option value="<?php echo $produto['id']; ?>" data-preco="<?php echo $produto['preco']; ?>">
                    <?php echo $produto['nome']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>

        <label for="preco_produto">Preço do Produto:</label>
        <input type="text" id="preco_produto" name="preco_produto" readonly>
        <br><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" min="1" required onchange="atualizarTotal()">
        <br><br>

        <label for="total">Valor Total:</label>
        <input type="text" id="total" name="total" readonly>
        <br><br>

        <button type="submit">Concluir Venda</button>
    </form>

    <script>
        // Função para atualizar o preço do produto selecionado
        function atualizarPreco() {
            const produtoSelect = document.getElementById('produto_id');
            const precoInput = document.getElementById('preco_produto');
            const selectedOption = produtoSelect.options[produtoSelect.selectedIndex];
            const preco = selectedOption.getAttribute('data-preco');
            precoInput.value = preco ? parseFloat(preco).toFixed(2) : '';
            atualizarTotal();
        }

        // Função para atualizar o valor total com base na quantidade
        function atualizarTotal() {
            const preco = parseFloat(document.getElementById('preco_produto').value) || 0;
            const quantidade = parseInt(document.getElementById('quantidade').value) || 0;
            const totalInput = document.getElementById('total');
            totalInput.value = (preco * quantidade).toFixed(2);
        }
    </script>
</body>
</html>
