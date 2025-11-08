<?php

include("conexao.php");
$clientes = obterRelatorioConsumo();

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Consumo</title>
</head>

<body>
    <h1>Top 10 Maiores Consumos</h1>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Kwh</th>
            <th>Valor Total (R$)</th>
        </tr>

        <?php foreach ($clientes as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['cpf']) ?></td>
                <td><?= number_format($row['kwh'], 2, ',', '.') ?></td>
                <td><?= number_format($row['valor_total'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <button onclick="history.back()">Voltar</button>
</body>
</html>