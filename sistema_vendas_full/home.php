<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

$nome = $_SESSION['usuario_nome'];

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <title>Home - Sistema de Vendas</title>
    <link rel="stylesheet" href="assets/css/estilo.css" />
  </head>

  <body>
    <div class="wrap">
      <div class="header">
        <div>Bem-vindo, <?php echo htmlspecialchars($nome); ?></div>
        <form method="POST" action="funcoes.php" style="margin: 0;">
          <input type="hidden" name="acao" value="logout" />
          <button type="submit">Sair</button>
        </form>
      </div>

      <h3>Cadastros</h3>
      <div class="grid">
        <a href="usuario.php" class="tile">Usuários</a>
        <a href="cliente.php" class="tile">Clientes</a>
        <a href="produto.php" class="tile">Produtos</a>
        <a href="marca.php" class="tile">Marcas</a>
        <a href="produto_grupo.php" class="tile">Grupos de Produto</a>
        <a href="condicao_pagamento.php" class="tile">Condições de Pagamento</a>
      </div>

      <h3>Vendas</h3>
      <div class="grid">
        <a href="vender.php" class="tile">Realizar Venda</a>
        <a href="vendas.php" class="tile">Listar Vendas</a>
      </div>

      <h3>Relatórios</h3>
      <div class="grid">
        <a href="relatorio_vendas_periodo.php" class="tile">Vendas por Período</a>
        <a href="relatorio_vendas_cliente.php" class="tile">Vendas por Cliente</a>
        <a href="relatorio_produtos_mais_vendidos.php" class="tile">Produtos mais Vendidos</a>
        <a href="relatorio_vendas_usuario.php" class="tile">Vendas por Usuário</a>
        <a href="relatorio_clientes_grupo.php" class="tile">Clientes por Grupo</a>
      </div>

       <div style="margin-top: 24px;">
        <a href="index.html" class="button" style="width: 200px;">⟵ Voltar ao Login</a>
      </div>
    </div>
  </body>
</html>
