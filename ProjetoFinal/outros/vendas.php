<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'vendas'); // Atualize conforme necessário

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para exibir as vendas
$sql = "
    SELECT 
        venda.id AS venda_id,
        usuario.nome AS usuario_nome,
        produto.nome AS produto_nome,
        venda.quantidade,
        venda.total,
        venda.condicao_pagamento,
        IFNULL(GROUP_CONCAT(parcela.numero_parcela ORDER BY parcela.numero_parcela), 'À vista') AS parcelas
    FROM venda
    LEFT JOIN usuario ON venda.usuario_id = usuario.id
    LEFT JOIN produto ON venda.produto_id = produto.id
    LEFT JOIN parcela ON parcela.venda_id = venda.id
    GROUP BY venda.id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Vendas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Listagem de Vendas</h1>
    <table>
        <thead>
            <tr>
                <th>ID Venda</th>
                <th>Usuário</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Total (R$)</th>
                <th>Condição de Pagamento</th>
                <th>Parcelas</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['venda_id']; ?></td>
                        <td><?php echo $row['usuario_nome']; ?></td>
                        <td><?php echo $row['produto_nome']; ?></td>
                        <td><?php echo $row['quantidade']; ?></td>
                        <td><?php echo number_format($row['total'], 2, ',', '.'); ?></td>
                        <td><?php echo ucfirst($row['condicao_pagamento']); ?></td>
                        <td><?php echo $row['parcelas']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhuma venda encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
