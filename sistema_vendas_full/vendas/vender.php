<?php require_once '../funcoes.php';
$usuarios = $conn->query("SELECT id,nome FROM usuario WHERE idnAtivo=1 ORDER BY nome");
$produtos = $conn->query("SELECT id,descricao,precoVenda FROM produto WHERE idnAtivo=1 ORDER BY descricao"); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Realizar Venda</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
    <div class="card" style="width:720px;max-width:92vw">
        <h2>Realizar Venda</h2>
        <form method="POST" action="condicao_pagamento_venda.php">
            <label>Usuário</label><select name="usuario_id" required>
                <option value="">Selecione</option>
                <?php while ($u = $usuarios->fetch_assoc()) {
                    echo "<option value='{$u['id']}'>" . htmlspecialchars($u['nome']) . "</option>";
                } ?>
            </select>
            <label>Produto</label><select name="produto_id" id="produto_id" required onchange="ap()">
                <option value="">Selecione</option>
                <?php while ($p = $produtos->fetch_assoc()) {
                    echo "<option value='{$p['id']}' data-preco='{$p['precoVenda']}'>" . htmlspecialchars($p['descricao']) . "</option>";
                } ?>
            </select>
            <label>Preço do Produto</label><input type="text" id="preco_produto" name="preco_produto" readonly>
            <label>Quantidade</label><input type="number" id="quantidade" name="quantidade" min="1" value="1" required onchange="at()">
            <label>Total</label><input type="text" id="total" name="total" readonly>
            <button type="button">Continuar</button>
        </form>
    </div>
    <script>
        function ap() {
            const o = document.getElementById('produto_id').selectedOptions[0];
            const p = o ? o.getAttribute('data-preco') : '';
            document.getElementById('preco_produto').value = p ? parseFloat(p).toFixed(2) : '';
            at();
        }

        function at() {
            const pr = parseFloat(document.getElementById('preco_produto').value) || 0;
            const q = parseInt(document.getElementById('quantidade').value) || 0;
            document.getElementById('total').value = (pr * q).toFixed(2);
        }
    </script>
</body>

</html>