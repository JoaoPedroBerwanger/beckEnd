<?php require_once "funcoes.php";
$sql = "SELECT v.id AS venda_id, v.numero, v.totalVenda, v.dataVenda, u.nome AS usuario_nome
        FROM vendas v LEFT JOIN usuario u ON v.idUsuario = u.id ORDER BY v.id DESC";
$res = $conn->query($sql); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
        <meta charset="UTF-8">
        <title>Vendas</title>
        <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>
        <div class="wrap">
                <div class="header">
                        <div>Listagem de Vendas</div>
                        <div><a class="button" href="../home.php">⟵ Voltar</a></div>
                </div>
                <table class="table">
                        <thead>
                                <tr>
                                        <th>ID</th>
                                        <th>Número</th>
                                        <th>Usuário</th>
                                        <th>Total (R$)</th>
                                        <th>Data</th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php if ($res && $res->num_rows > 0): while ($r = $res->fetch_assoc()): ?>
                                                <tr>
                                                        <td><?php echo $r['venda_id']; ?></td>
                                                        <td><?php echo $r['numero']; ?></td>
                                                        <td><?php echo htmlspecialchars($r['usuario_nome']); ?></td>
                                                        <td><?php echo number_format($r['totalVenda'], 2, ',', '.'); ?></td>
                                                        <td><?php echo date('d/m/Y H:i', strtotime($r['dataVenda'])); ?></td>
                                                </tr>
                                        <?php endwhile;
                                else: ?><tr>
                                                <td colspan="5">Nenhuma venda encontrada.</td>
                                        </tr><?php endif; ?>
                        </tbody>
                </table>
                <p><a class="button" href="../home.php">⟵ Voltar ao Menu</a></p>
        </div>
</body>

</html>