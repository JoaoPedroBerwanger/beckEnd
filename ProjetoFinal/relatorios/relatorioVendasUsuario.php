<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit;
}

require_once '../funcoes.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório: Vendas por Usuário</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body class="bg">
<div class="wrap">

    <div class="header">
        <div>Relatório: Vendas por Usuário</div>
        <div style="display:flex; gap:10px;">
            <a class="button" onclick="window.print()">Imprimir</a>
            <a class="button" href="../home.php">Voltar</a>
        </div>
    </div>

    <div class="form">

        <h2 style="margin-bottom:20px;">Resumo de Vendas por Usuário</h2>

        <?php
        $query = "SELECT u.id, u.nome, COUNT(v.id) AS qtd_vendas, COALESCE(SUM(v.totalVenda),0) AS total
                FROM usuario u
                LEFT JOIN vendas v ON v.idUsuario = u.id
                GROUP BY u.id, u.nome
                HAVING COUNT(v.id) > 0
                ORDER BY total DESC";

        $res = $conn->query($query);
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Qtd. Vendas</th>
                    <th>Total (R$)</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($res && $res->num_rows > 0): ?>
                <?php while ($r = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['nome']) ?></td>
                        <td><?= $r['qtd_vendas'] ?></td>
                        <td>R$ <?= number_format($r['total'], 2, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">Sem dados de vendas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>
</body>

</html>
