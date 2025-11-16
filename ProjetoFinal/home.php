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
        <div>Bem vindo, <?php echo htmlspecialchars($nome); ?></div>
        <form method="POST" action="funcoes.php" style="margin: 0;">
          <input type="hidden" name="acao" value="logout" />
          <button type="submit" class="button">Sair</button>
        </form>
      </div>

      <h3>Clientes</h3>
      <div class="grid">
        <a href="cliente/cliente_consulta.php" class="tile">Clientes</a>
        <a href="cliente/clienteGrupo_consulta.php" class="tile">Grupo de Clientes</a>
      </div>

      <h3>Produtos</h3>
      <div class="grid">
        <a href="produto/produto_consulta.php" class="tile">Produtos</a>
        <a href="produto/marca_consulta.php" class="tile">Marcas</a>
        <a href="produto/produtoGrupo_consulta.php" class="tile">Grupos de Produto</a>
      </div>

      <h3>Gerais</h3>
      <div class="grid">
        <a href="usuario/usuario_consulta.php" class="tile">Usuários</a>
        <a href="vendas/condicaoPagamento_consulta.php" class="tile">Condição de Pagamento</a>
        <a href="vendas/formaPagamento_consulta.php" class="tile">Forma de Pagamento</a>
      </div>

      <h3>Vendas</h3>
      <div class="grid">
        <a href="vendas/venda_form.php" class="tile">Realizar Venda</a>
        <a href="vendas/venda_consulta.php" class="tile">Consultar Vendas</a>
      </div>

      <h3>Relatórios</h3>
      <div class="grid">
        <a href="relatorios/relatorioVendasPeriodo.php" class="tile">Vendas por Período</a>
        <a href="relatorios/relatorioVendasCliente.php" class="tile">Vendas por Cliente</a>
        <a href="relatorios/relatorioProdutosMaisVendidos.php" class="tile">Produtos mais Vendidos</a>
        <a href="relatorios/relatorioVendasUsuario.php" class="tile">Vendas por Usuário</a>
        <a href="relatorios/relatorioClientesGrupo.php" class="tile">Clientes por Grupo</a>
      </div>

      <div style="margin-top: 24px;">
        <a href="index.html" class="button" style="width: 200px;">Voltar ao Login</a>
      </div>
    </div>
  </body>
</html>
