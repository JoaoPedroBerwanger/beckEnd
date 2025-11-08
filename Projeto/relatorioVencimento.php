<?php

include("conexao.php");
$clientes = obterRelatorioVencimento();

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vencimentos</title>
</head>

<body>
    <h1>Clientes com Maior Data de Vencimento</h1>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Vencimento</th>
            <th>Valor Total (R$)</th>
        </tr>

        <?php foreach ($clientes as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['cpf']) ?></td>
                <td><?= date('d/m/Y', strtotime($row['data_vencimento'])) ?></td>
                <td><?= number_format($row['valor_total'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <button onclick="history.back()">Voltar</button>
</body>
</html>