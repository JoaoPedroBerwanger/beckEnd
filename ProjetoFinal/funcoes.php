<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_vendas";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"])) {
  switch ($_POST["acao"]) {

    case "entrar": entrarSistema(); break;
    case "logout": fazerLogout(); break;

    case "addUsuario": addUsuario(); break;
    case "editarUsuario": editUsuario(); break;
    case "addUsuarioLogin": addUsuarioLogin(); break;
    case "delUsuario": delUsuario(); break;

    case "addCliente": addCliente(); break;
    case "editarCliente": editCliente(); break;
    case "delCliente": delCliente(); break;

    case "addGrupoCliente": addGrupoCliente(); break;
    case "editGrupoCliente": editGrupoCliente(); break;
    case "delGrupoCliente": delGrupoCliente(); break;

    case "addGrupoProduto": addGrupoProduto(); break;
    case "editGrupoProduto": editGrupoProduto(); break;
    case "delGrupoProduto": delGrupoProduto(); break;

    case 'addProduto': addProduto(); break;
    case 'editProduto': editProduto(); break;
    case 'delProduto': delProduto(); break;

    case "addMarca": addMarca(); break;
    case "editarMarca": editMarca(); break;
    case "delMarca": delMarca(); break;

    case 'addCondicaoPagamento': addCondicaoPagamento(); break;
    case 'editCondicaoPagamento': editCondicaoPagamento(); break;
    case 'delCondicaoPagamento': delCondicaoPagamento(); break;

    case 'addFormaPagamento': addFormaPagamento(); break;
    case 'editFormaPagamento': editFormaPagamento(); break;
    case 'delFormaPagamento': delFormaPagamento(); break;

    case 'finalizarVenda': finalizarVenda(); break;
    case 'cancelarVenda': cancelarVenda(); break;

  }
}

function finalizarVenda() {
  global $conn;
  session_start();

  if (empty($_SESSION['produtosVenda'])) {
    header("Location: vendas/venda_form.php?erro=sem_itens");
    
    exit;
  }

  $idCliente = intval($_POST['idCliente'] ?? 0);
  $idCondicaoPagamento = intval($_POST['idCondicaoPagamento'] ?? 0);
  $idFormaPagamento = intval($_POST['idFormaPagamento'] ?? 0);
  $descontoGlobal = floatval($_POST['descontoGlobal'] ?? 0);
  $idUsuario = intval($_SESSION['usuario_id'] ?? 0);

  if ($idCliente <= 0 || $idCondicaoPagamento <= 0 || $idFormaPagamento <= 0 || $idUsuario <= 0) {
    header("Location: vendas/venda_form.php?erro=dados");
    exit;
  }

  // total dos produtos
  $totalProdutos = 0;

  foreach ($_SESSION['produtosVenda'] as $prod) {
    $totalProdutos += $prod['total'];
  }

  $totalVenda = $totalProdutos - $descontoGlobal;
  if ($totalVenda < 0) $totalVenda = 0;

  // gera número sequencial
  $qNum = $conn->query("SELECT COALESCE(MAX(numero), 0) + 1 AS prox FROM vendas");
  $prox = $qNum && $qNum->num_rows ? $qNum->fetch_assoc()['prox'] : 1;

  // grava cabeçalho da venda
  $insertVenda = "INSERT INTO vendas 
      (numero, idCliente, idCondicaoPagamento, idFormaPagamento, totalVenda, dataVenda, idUsuario, idnCancelada)
      VALUES ($prox, $idCliente, $idCondicaoPagamento, $idFormaPagamento, $totalVenda, NOW(), $idUsuario, 0)";

  if (!$conn->query($insertVenda)) {
    header("Location: vendas/venda_form.php?erro=db");
    exit;
  }

  $idVenda = $conn->insert_id;

  foreach ($_SESSION['produtosVenda'] as $prod) {
    $idProduto = intval($prod['idProduto']);
    $quantidade = floatval($prod['quantidade']);
    $desconto = floatval($prod['desconto']);
    $precoVenda = floatval($prod['precoVenda']);
    $precoCusto = floatval($prod['precoCusto']);
    $total = floatval($prod['total']);

    $insertProdVenda = "INSERT INTO venda_produtos 
        (idVenda, idProduto, quantidade, desconto, precoVenda, precoCusto, total)
        VALUES ($idVenda, $idProduto, $quantidade, $desconto, $precoVenda, $precoCusto, $total)";

    $conn->query($insertProdVenda);
  }

  // limpa os produtos da sessão
  $_SESSION['produtosVenda'] = [];

  header("Location: vendas/venda_form.php?msg=ok");
  exit;
}

function cancelarVenda() {
  global $conn;
  session_start();

  $id = intval($_POST['id'] ?? 0);

  if ($id <= 0) {
    header("Location: vendas/venda_consulta.php?erro=id");
    exit;
  }

  $query = "UPDATE vendas SET idnCancelada = 1 WHERE id = $id";

  if ($conn->query($query)) {
    header("Location: vendas/venda_consulta.php?msg=cancelada");
  } else {
    header("Location: vendas/venda_consulta.php?erro=db");
  }

  exit;
}

function entrarSistema() {
  global $conn;

  $login = trim($_POST['login'] ?? '');
  $senha = trim($_POST['senha'] ?? '');

  if ($login === '' || $senha === '') {
    header("Location: index.html?erro=1");
    exit;
  }

  $senhaMd5 = md5($senha);

  $query = "SELECT id, nome, login FROM usuario WHERE login = '$login' AND senha = '$senhaMd5' AND idnAtivo = 1";

  $select = $conn->query($query);

  if (!$select || $select->num_rows === 0) {
    header("Location: index.html?erro=invalido");
    exit;
  }

  $resultado = $select->fetch_assoc();
  $_SESSION['usuario_id'] = $resultado['id'];
  $_SESSION['usuario_nome'] = $resultado['nome'];
  $_SESSION['usuario_login'] = $resultado['login'];

  header("Location: home.php");
  exit;
}

function fazerLogout() {
  session_unset();
  session_destroy();
  header("Location: index.html");
  exit;
}

function addUsuario() {
  global $conn;

  $login = trim($_POST['login']);
  $nome  = trim($_POST['nome']);
  $senha = trim($_POST['senha']);

  if ($login === '' || $nome === '' || $senha === '') {
    header("Location: usuario/usuario_form.php?erro=campos");
    exit;
  }

  $existe = $conn->query("SELECT id FROM usuario WHERE login='$login'");
  if ($existe && $existe->num_rows > 0) {
    header("Location: usuario/usuario_form.php?erro=loginDuplicado");
    exit;
  }

  $senhaMd5 = md5($senha);
  $query = "INSERT INTO usuario (nome, login, senha, idnAtivo) 
          VALUES ('$nome', '$login', '$senhaMd5', 1)";
  
  if ($conn->query($query)) {
    header("Location: usuario/usuario_consulta.php?msg=ok");
  } else {
    header("Location: usuario/usuario_form.php?erro=db");
  }
  
  exit;
}

function addUsuarioLogin() {
  global $conn;

  $login = trim($_POST['login']);
  $nome  = trim($_POST['nome']);
  $senha = trim($_POST['senha']);

  if ($login === '' || $nome === '' || $senha === '') {
    header("Location: usuario/usuarioLogin_form.php?erro=campos");
    exit;
  }

  $existe = $conn->query("SELECT id FROM usuario WHERE login='$login'");
  if ($existe && $existe->num_rows > 0) {
    header("Location: usuario/usuarioLogin_form.php?erro=loginDuplicado");
    exit;
  }

  $senhaMd5 = md5($senha);
  $query = "INSERT INTO usuario (nome, login, senha, idnAtivo) 
          VALUES ('$nome', '$login', '$senhaMd5', 1)";
  
  if ($conn->query($query)) {
    header("Location: index.html?msg=ok");
  } else {
    header("Location: usuario/usuarioLogin_form.php?erro=db");
  }
  
  exit;
}

function editUsuario() {
  global $conn;
  
  $id = intval($_POST['id']);
  $nome = trim($_POST['nome']);
  $login = trim($_POST['login']);
  $senha = trim($_POST['senha']);
  $idnAtivo = intval($_POST['idnAtivo']);

  if ($senha !== '') {
    $senhaMd5 = md5($senha);
    $query = "UPDATE usuario 
            SET nome='$nome', login='$login', senha='$senhaMd5', idnAtivo=$idnAtivo 
            WHERE id=$id";
  } else {
    $query = "UPDATE usuario 
            SET nome='$nome', login='$login', idnAtivo=$idnAtivo 
            WHERE id=$id";
  }

  if ($conn->query($query)) {
    header("Location: usuario/usuario_consulta.php?msg=ok");
  } else {
    header("Location: usuario/usuario_form.php?erro=db");
  }
  exit;
}

function delUsuario() {
  global $conn;

  $id = intval($_POST['id']);
  
  if ($conn->query("DELETE FROM usuario WHERE id=$id")) {
    header("Location: usuario/usuario_consulta.php?msg=ok");
    
    exit;
  }

  $conn->query("UPDATE usuario SET idnAtivo = 0 WHERE id = $id");
  header("Location: usuario/usuario_consulta.php?msg=desativado");
    
  exit;
}

function addCliente() {
  global $conn;

  $nome = trim($_POST['nome']);
  $cpfCnpj = trim($_POST['cpfCnpj']);
  $rua = trim($_POST['rua']);
  $bairro = trim($_POST['bairro']);
  $numero = intval($_POST['numero']);
  $cep = trim($_POST['cep']);
  $email = trim($_POST['email']);
  $idGrupoCliente = isset($_POST['idGrupoCliente']) && intval($_POST['idGrupoCliente']) > 0 ? intval($_POST['idGrupoCliente']) : null;

  $idGrupoClienteQuery = $idGrupoCliente !== null ? $idGrupoCliente : "NULL";

  $query = "INSERT INTO cliente (nome, cpfCnpj, rua, bairro, numero, cep, email, idGrupoCliente, idnAtivo)
          VALUES ('$nome', '$cpfCnpj', '$rua', '$bairro', $numero, '$cep', '$email', $idGrupoClienteQuery, 1)";
  
  if ($conn->query($query)) {
    header("Location: cliente/cliente_consulta.php?msg=ok");
  } else {
    header("Location: cliente/cliente_form.php?erro=db");
  }
  
  $conn->close();
  exit;
}

function editCliente() {
  global $conn;

  $id = intval($_POST['id']);
  $nome = trim($_POST['nome']);
  $cpfCnpj = trim($_POST['cpfCnpj']);
  $rua = trim($_POST['rua']);
  $bairro = trim($_POST['bairro']);
  $numero = intval($_POST['numero']);
  $cep = trim($_POST['cep']);
  $email = trim($_POST['email']);
  $idGrupoCliente = isset($_POST['idGrupoCliente']) && intval($_POST['idGrupoCliente']) > 0 ? intval($_POST['idGrupoCliente']) : null;
  $idGrupoClienteQuery = $idGrupoCliente !== null ? $idGrupoCliente : "NULL";
  $idnAtivo = intval($_POST['idnAtivo']);

  $query = "UPDATE cliente 
            SET 
              nome = '$nome', 
              cpfCnpj = '$cpfCnpj', 
              rua = '$rua',
              bairro = '$bairro',
              numero = $numero,
              cep = '$cep',
              email = '$email', 
              idGrupoCliente = $idGrupoClienteQuery,
              idnAtivo = $idnAtivo
            WHERE id = $id";

  if ($conn->query($query)) {
    header("Location: cliente/cliente_consulta.php?msg=ok");
  } else {
    header("Location: cliente/cliente_form.php?erro=db");
  }

  exit;
}

function delCliente() {
  global $conn;

  $id = intval($_POST['id']);

  $q = $conn->query("SELECT COUNT(*) AS total FROM vendas WHERE idCliente = $id");
  $r = $q->fetch_assoc();

  if ($r['total'] == 0) {
    if ($conn->query("DELETE FROM cliente WHERE id = $id")) {
      header("Location: cliente/cliente_consulta.php?msg=excluido");
      exit;
    } else {
      header("Location: cliente/cliente_consulta.php?erro=db");
      exit;
    }
  } else {
    $conn->query("UPDATE cliente SET idnAtivo = 0 WHERE id = $id");
    header("Location: cliente/cliente_consulta.php?msg=desativado");
    exit;
  }
}

function addGrupoCliente() {
  global $conn;

  $descricao = trim($_POST['descricao']);

  if ($descricao === '') {
    header("Location: cliente/clienteGrupo_form.php?erro=1");
    
    exit;
  }

  $query = "INSERT INTO cliente_grupo (descricao, idnAtivo) VALUES ('$descricao', 1)";
  
  if ($conn->query($query)) {
    header("Location: cliente/clienteGrupo_consulta.php?msg=ok");
  } else {
    header("Location: cliente/clienteGrupo_form.php?erro=db");
  }

  exit;
}

function editGrupoCliente() {
  global $conn;

  $id = intval($_POST['id']);
  $descricao = trim($_POST['descricao']);
  $idnAtivo = intval($_POST['idnAtivo']);

  $query = "UPDATE cliente_grupo SET descricao='$descricao', idnAtivo=$idnAtivo WHERE id=$id";
  
  if ($conn->query($query)) {
    header("Location: cliente/clienteGrupo_consulta.php?msg=ok");
  } else {
    header("Location: cliente/clienteGrupo_form.php?erro=db");
  }
  
  exit;
}

function delGrupoCliente() {
  global $conn;

  $id = intval($_POST['id']);

  if ($id <= 0) {
    header("Location: cliente/clienteGrupo_consulta.php?erro=id");
    exit;
  }

  $q = $conn->query("SELECT COUNT(*) AS total FROM cliente WHERE idGrupoCliente = $id");
  $r = $q->fetch_assoc();

  if ($r['total'] == 0) {
      // Pode excluir o grupo
      if ($conn->query("DELETE FROM cliente_grupo WHERE id = $id")) {
        header("Location: cliente/clienteGrupo_consulta.php?msg=excluido");
        exit;
      } else {
        header("Location: cliente/clienteGrupo_consulta.php?erro=db");
        exit;
      }
  } else {
      $conn->query("UPDATE cliente_grupo SET idnAtivo = 0 WHERE id = $id");
      header("Location: cliente/clienteGrupo_consulta.php?msg=desativado");
      exit;
  }
}

function listarMarcas() {
  global $conn;

  $consulta = $conn->query("SELECT id, descricao FROM marca WHERE idnAtivo = 1 ORDER BY id");
  
  return $consulta ? $consulta->fetch_all(MYSQLI_ASSOC) : [];
}

function listarGruposProduto() {
  global $conn;

  $consulta = $conn->query("SELECT id, descricao FROM produto_grupo WHERE idnAtivo = 1 ORDER BY id");
  
  return $consulta ? $consulta->fetch_all(MYSQLI_ASSOC) : [];
}

function addMarca() {
  global $conn;

  $descricao = trim($_POST['descricao']);

  if ($descricao === '') {
    header("Location: produto/marca_form.php?modo=novo&erro=1");
    exit;
  }

  $query = "INSERT INTO marca (descricao, idnAtivo) VALUES ('$descricao', 1)";
  $conn->query($query);

  header("Location: produto/marca_consulta.php?msg=ok");
  
  exit;
}

function editMarca() {
  global $conn;

  $id = intval($_POST['id']);
  $descricao = trim($_POST['descricao']);
  $idnAtivo  = intval($_POST['idnAtivo']);

  $query = "UPDATE marca SET descricao='$descricao', idnAtivo=$idnAtivo WHERE id=$id";
  $conn->query($query);

  header("Location: produto/marca_consulta.php?msg=ok");
 
  exit;
}

function delMarca() {
  global $conn;

  $id = intval($_POST['id']);

  if ($conn->query("DELETE FROM marca WHERE id=$id")) {
    header("Location: produto/marca_consulta.php?msg=ok");
    
    exit;
  }

  $conn->query("UPDATE marca SET idnAtivo = 0 WHERE id=$id");
  header("Location: produto/marca_consulta.php?msg=desativado");
  
  exit;
}

function addGrupoProduto() {
  global $conn;

  $descricao = trim($_POST['descricao']);

  if ($descricao === '') {
    header("Location: produtoGrupo_form.php?erro=1");
    exit;
  }

  $query = "INSERT INTO produto_grupo (descricao, idnAtivo) VALUES ('$descricao', 1)";

  if ($conn->query($query)) {
    header("Location: produto/produtoGrupo_consulta.php?msg=ok");
  } else {
    header("Location: produto/produtoGrupo_form.php?erro=db");
  }

  exit;
}

function editGrupoProduto() {
  global $conn;

  $id = intval($_POST['id']);
  $descricao = trim($_POST['descricao']);
  $idnAtivo = intval($_POST['idnAtivo']);

  $query = "UPDATE produto_grupo SET descricao='$descricao', idnAtivo=$idnAtivo WHERE id=$id";

  if ($conn->query($query)) {
    header("Location: produto/produtoGrupo_consulta.php?msg=ok");
  } else {
    header("Location: produto/produtoGrupo_form.php?erro=db");
  }

  exit;
}

function delGrupoProduto() {
  global $conn;

  $id = intval($_POST['id']);

  if ($id <= 0) {
    header("Location: produto/produtoGrupo_consulta.php?erro=id");
    exit;
  }

  $q = $conn->query("SELECT COUNT(*) AS grupos FROM produto WHERE idGrupoProduto = $id");
  $r = $q->fetch_assoc();

  if ($r['grupos'] == 0) {
      if ($conn->query("DELETE FROM produto_grupo WHERE id = $id")) {
        header("Location: produto/produtoGrupo_consulta.php?msg=excluido");
        exit;
      } else {
        header("Location: produto/produtoGrupo_consulta.php?erro=db");
        exit;
      }
  } else {
      $conn->query("UPDATE produto_grupo SET idnAtivo = 0 WHERE id = $id");
      header("Location: produto/produtoGrupo_consulta.php?msg=desativado");
      exit;
  }
}

function addCondicaoPagamento() {
  global $conn;

  $descricao = trim($_POST['descricao']);
  if ($descricao === '') {
    header("Location: vendas/condicaoPagamento_form.php?erro=1");
    exit;
  }

  $sql = "INSERT INTO condicao_pagamento (descricao, idnAtivo) VALUES ('$descricao', 1)";

  if ($conn->query($sql)) {
    header("Location: vendas/condicaoPagamento_consulta.php?msg=ok");
  } else {
    header("Location: vendas/condicaoPagamento_form.php?erro=db");
  }
  exit;
}

function editCondicaoPagamento() {
  global $conn;

  $id = intval($_POST['id']);
  $descricao = trim($_POST['descricao']);
  $idnAtivo = intval($_POST['idnAtivo']);

  $sql = "UPDATE condicao_pagamento SET descricao='$descricao', idnAtivo=$idnAtivo WHERE id=$id";

  if ($conn->query($sql)) {
    header("Location: vendas/condicaoPagamento_consulta.php?msg=ok");
  } else {
    header("Location: vendas/condicaoPagamento_form.php?erro=db");
  }
  exit;
}

function delCondicaoPagamento() {
  global $conn;

  $id = intval($_POST['id']);

  if ($conn->query("DELETE FROM condicao_pagamento WHERE id=$id")) {
    header("Location: vendas/condicaoPagamento_consulta.php?msg=ok");
    exit;
  }

  $conn->query("UPDATE condicao_pagamento SET idnAtivo=0 WHERE id=$id");
  header("Location: vendas/condicaoPagamento_consulta.php?msg=desativado");
  exit;
}

function addFormaPagamento() {
  global $conn;

  $descricao = trim($_POST['descricao']);
  if ($descricao === '') {
    header("Location: vendas/formaPagamento_form.php?erro=1");
    exit;
  }

  $sql = "INSERT INTO forma_pagamento (descricao, idnAtivo) VALUES ('$descricao', 1)";

  if ($conn->query($sql)) {
    header("Location: vendas/formaPagamento_consulta.php?msg=ok");
  } else {
    header("Location: vendas/formaPagamento_form.php?erro=db");
  }
  exit;
}

function editFormaPagamento() {
  global $conn;

  $id = intval($_POST['id']);
  $descricao = trim($_POST['descricao']);
  $idnAtivo = intval($_POST['idnAtivo']);

  $sql = "UPDATE forma_pagamento SET descricao='$descricao', idnAtivo=$idnAtivo WHERE id=$id";

  if ($conn->query($sql)) {
    header("Location: vendas/formaPagamento_consulta.php?msg=ok");
  } else {
    header("Location: vendas/formaPagamento_form.php?erro=db");
  }
  exit;
}

function delFormaPagamento() {
  global $conn;

  $id = intval($_POST['id']);

  if ($conn->query("DELETE FROM forma_pagamento WHERE id=$id")) {
    header("Location: vendas/formaPagamento_consulta.php?msg=ok");
    exit;
  }

  $conn->query("UPDATE forma_pagamento SET idnAtivo = 0 WHERE id=$id");
  header("Location: vendas/formaPagamento_consulta.php?msg=desativado");
  exit;
}

function addProduto() {
  global $conn;

  $descricao = trim($_POST['descricao'] ?? '');
  $precoVenda = floatval($_POST['precoVenda'] ?? 0);
  $precoCusto = floatval($_POST['precoCusto'] ?? 0);
  $idMarca = !empty($_POST['idMarcaProduto']) ? intval($_POST['idMarcaProduto']) : 'NULL';
  $idGrupo = !empty($_POST['idGrupoProduto']) ? intval($_POST['idGrupoProduto']) : 'NULL';

  if ($descricao === '') {
    header("Location: produto/produto_form.php?erro=1");
    
    exit;
  }

  $query = "INSERT INTO produto (descricao, precoVenda, precoCusto, idMarcaProduto, idGrupoProduto, idnAtivo)
    VALUES ('$descricao', $precoVenda, $precoCusto, $idMarca, $idGrupo, 1)";

  if ($conn->query($query)) {
    header("Location: produto/produto_consulta.php?msg=ok");
  } else {
    header("Location: produto/produto_form.php?erro=db");
  }

  exit;
}

function editProduto() {
  global $conn;

  $id = intval($_POST['id'] ?? 0);
  $descricao = trim($_POST['descricao'] ?? '');
  $precoVenda = floatval($_POST['precoVenda'] ?? 0);
  $precoCusto = floatval($_POST['precoCusto'] ?? 0);
  $idMarca = !empty($_POST['idMarcaProduto']) ? intval($_POST['idMarcaProduto']) : 'NULL';
  $idGrupo = !empty($_POST['idGrupoProduto']) ? intval($_POST['idGrupoProduto']) : 'NULL';
  $idnAtivo = intval($_POST['idnAtivo'] ?? 0);

  if ($id <= 0) {
    header("Location: produto/produto_consulta.php?erro=id");
    exit;
  }

  $sql = "
    UPDATE produto
       SET descricao='$descricao',
           precoVenda=$precoVenda,
           precoCusto=$precoCusto,
           idMarcaProduto=$idMarca,
           idGrupoProduto=$idGrupo,
           idnAtivo=$idnAtivo
     WHERE id=$id
  ";

  if ($conn->query($sql)) {
    header("Location: produto/produto_consulta.php?msg=ok");
  } else {
    header("Location: produto/produto_form.php?id=$id&erro=db");
  }

  exit;
}

function delProduto() {
  global $conn;

  $id = intval($_POST['id'] ?? 0);

  if ($id <= 0) {
    header("Location: produto/produto_consulta.php?erro=id");
    exit;
  }

  $q = $conn->query("SELECT COUNT(*) AS total FROM venda_produtos WHERE idProduto = $id");
  $r = $q->fetch_assoc();

  if ($r['total'] == 0) {
      if ($conn->query("DELETE FROM produto WHERE id=$id")) {
          header("Location: produto/produto_consulta.php?msg=excluido");
          exit;
      } else {
          header("Location: produto/produto_consulta.php?erro=db");
          exit;
      }
  } 
  else {
      $conn->query("UPDATE produto SET idnAtivo = 0 WHERE id=$id");
      header("Location: produto/produto_consulta.php?msg=desativado");
      exit;
  }
}
