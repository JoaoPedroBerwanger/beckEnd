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
    case "cadUsuario": cadastrarUsuario(); break;
    case "addUsuario": inserirUsuario(); break;
    case "editarUsuario": atualizarUsuario(); break;
    case "delUsuario": excluirUsuario(); break;
    case "addCliente": inserirCliente(); break;
    case "editarCliente": atualizarCliente(); break;
    case "delCliente": excluirCliente(); break;
    case "addGrupoCliente": inserirGrupoCliente(); break;
    case "editarGrupoCliente": atualizarGrupoCliente(); break;
    case "delGrupoCliente": excluirGrupoCliente(); break;
  }
}

function cadastrarUsuario()
{
  global $conn;

  $login = trim($_POST['login'] ?? '');
  $nome  = trim($_POST['nome']  ?? '');
  $senha = trim($_POST['senha'] ?? '');

  if ($login === '' || $nome === '' || $senha === '') {
    header("Location: usuarios/usuario_form.php?erro=1");
    exit;
  }

  $check = $conn->query("SELECT id FROM usuario WHERE login = '$login'");
  if ($check && $check->num_rows > 0) {
    header("Location: usuarios/usuario_form.php?erro=loginDuplicado");
    exit;
  }

  $senhaMd5 = md5($senha);
  $sql = "INSERT INTO usuario (nome, login, senha, idnAtivo) 
          VALUES ('$nome', '$login', '$senhaMd5', 1)";

  if ($conn->query($sql)) {
    header("Location: usuarios/usuario_consultar.php?cad=ok");
  } else {
    header("Location: usuarios/usuario_form.php?erro=db");
  }
  exit;
}

function entrarSistema()
{
  global $conn;

  $login = trim($_POST['login'] ?? '');
  $senha = trim($_POST['senha'] ?? '');

  if ($login === '' || $senha === '') {
    header("Location: index.html?erro=1");
    exit;
  }

  $senhaMd5 = md5($senha);
  $sql = "SELECT id, nome, login 
          FROM usuario 
          WHERE login = '$login' AND senha = '$senhaMd5' AND idnAtivo = 1";

  $res = $conn->query($sql);

  if (!$res || $res->num_rows === 0) {
    header("Location: index.html?erro=invalido");
    exit;
  }

  $u = $res->fetch_assoc();
  $_SESSION['usuario_id'] = $u['id'];
  $_SESSION['usuario_nome'] = $u['nome'];
  $_SESSION['usuario_login'] = $u['login'];

  header("Location: home.php");
  exit;
}


function fazerLogout()
{
  session_unset();
  session_destroy();
  header("Location: index.html");
  exit;
}


function atualizarUsuario() {
  global $conn;
  $id = intval($_POST['id']);
  $nome = trim($_POST['nome']);
  $login = trim($_POST['login']);
  $senha = trim($_POST['senha']);
  $idnAtivo = intval($_POST['idnAtivo']);

  if ($senha !== '') {
    $senhaMd5 = md5($senha);
    $sql = "UPDATE usuario 
            SET nome='$nome', login='$login', senha='$senhaMd5', idnAtivo=$idnAtivo 
            WHERE id=$id";
  } else {
    $sql = "UPDATE usuario 
            SET nome='$nome', login='$login', idnAtivo=$idnAtivo 
            WHERE id=$id";
  }

  if ($conn->query($sql)) {
    header("Location: usuarios/usuario_consulta.php?msg=ok");
  } else {
    echo "<div class='error'>Erro ao atualizar: {$conn->error}</div>";
  }
  exit;
}

function excluirUsuario() {
  global $conn;
  $id = intval($_POST['id']);
  $conn->query("DELETE FROM usuario WHERE id=$id");
  header("Location: usuarios/usuario_consulta.php?msg=ok");
  exit;
}

function inserirUsuario() {
  global $conn;
  $login = trim($_POST['login']);
  $nome  = trim($_POST['nome']);
  $senha = trim($_POST['senha']);

  if ($login === '' || $nome === '' || $senha === '') {
    header("Location: usuarios/usuario_form.php?erro=campos");
    exit;
  }

  $check = $conn->query("SELECT id FROM usuario WHERE login='$login'");
  if ($check && $check->num_rows > 0) {
    header("Location: usuarios/usuario_form.php?erro=loginDuplicado");
    exit;
  }

  $senhaMd5 = md5($senha);
  $sql = "INSERT INTO usuario (nome, login, senha, idnAtivo) 
          VALUES ('$nome', '$login', '$senhaMd5', 1)";
  if ($conn->query($sql)) {
    header("Location: index.html?cad=ok");
  } else {
    echo "<div class='error'>Erro ao inserir: {$conn->error}</div>";
  }
  exit;
}

function inserirCliente() {
  global $conn;
  $nome = trim($_POST['nome']);
  $cpfCnpj = trim($_POST['cpfCnpj']);
  $email = trim($_POST['email']);
  $idGrupoCliente = intval($_POST['idGrupoCliente']);

  $sql = "INSERT INTO cliente (nome, cpfCnpj, email, idGrupoCliente, idnAtivo)
          VALUES ('$nome', '$cpfCnpj', '$email', $idGrupoCliente, 1)";
  if ($conn->query($sql)) {
    header("Location: cliente.php?msg=ok");
  } else {
    header("Location: cliente.php?erro=db");
  }
  exit;
}

function atualizarCliente() {
  global $conn;
  $id = intval($_POST['id']);
  $nome = trim($_POST['nome']);
  $cpfCnpj = trim($_POST['cpfCnpj']);
  $email = trim($_POST['email']);
  $idGrupoCliente = intval($_POST['idGrupoCliente']);
  $idnAtivo = intval($_POST['idnAtivo']);

  $sql = "UPDATE cliente 
          SET nome='$nome', cpfCnpj='$cpfCnpj', email='$email', 
              idGrupoCliente=$idGrupoCliente, idnAtivo=$idnAtivo
          WHERE id=$id";
  if ($conn->query($sql)) {
    header("Location: cliente.php?msg=ok");
  } else {
    header("Location: cliente.php?erro=db");
  }
  exit;
}


function excluirCliente() {
  global $conn;
  $id = intval($_POST['id']);
  $conn->query("DELETE FROM cliente WHERE id=$id");
  header("Location: cliente.php?msg=ok");
  exit;
}

function inserirGrupoCliente() {
  global $conn;
  $descricao = trim($_POST['descricao']);

  if ($descricao === '') {
    header("Location: cliente_grupo.php?erro=1");
    exit;
  }

  $sql = "INSERT INTO cliente_grupo (descricao, idnAtivo) VALUES ('$descricao', 1)";
  if ($conn->query($sql)) {
    header("Location: cliente_grupo.php?msg=ok");
  } else {
    header("Location: cliente_grupo.php?erro=db");
  }
  exit;
}

function atualizarGrupoCliente() {
  global $conn;
  $id = intval($_POST['id']);
  $descricao = trim($_POST['descricao']);
  $idnAtivo = intval($_POST['idnAtivo']);

  $sql = "UPDATE cliente_grupo SET descricao='$descricao', idnAtivo=$idnAtivo WHERE id=$id";
  if ($conn->query($sql)) {
    header("Location: cliente_grupo.php?msg=ok");
  } else {
    header("Location: cliente_grupo.php?erro=db");
  }
  exit;
}

function excluirGrupoCliente() {
  global $conn;
  $id = intval($_POST['id']);
  $conn->query("DELETE FROM cliente_grupo WHERE id=$id");
  header("Location: cliente_grupo.php?msg=ok");
  exit;
}

function listarProdutos() {
  global $conn;
  $sql = "
    SELECT p.id, p.descricao, m.descricao AS marca, g.descricao AS grupo,
           p.precoVenda, p.precoCusto, p.idnAtivo
    FROM produto p
    LEFT JOIN marca m ON p.idMarcaProduto = m.id
    LEFT JOIN produto_grupo g ON p.idGrupoProduto = g.id
    ORDER BY p.descricao
  ";
  $res = $conn->query($sql);
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

function obterProduto($id) {
  global $conn;
  $id = intval($id);
  $sql = "SELECT * FROM produto WHERE id = $id";
  $res = $conn->query($sql);
  return $res && $res->num_rows ? $res->fetch_assoc() : null;
}

function salvarProduto($d) {
  global $conn;

  $descricao = $conn->real_escape_string($d['descricao']);
  $precoVenda = floatval($d['precoVenda']);
  $precoCusto = floatval($d['precoCusto']);
  $idMarca = $d['idMarcaProduto'] ? intval($d['idMarcaProduto']) : 'NULL';
  $idGrupo = $d['idGrupoProduto'] ? intval($d['idGrupoProduto']) : 'NULL';
  $idnAtivo = intval($d['idnAtivo']);

  if (!empty($d['id']) && $d['id'] > 0) {
    $id = intval($d['id']);
    $sql = "
      UPDATE produto
      SET descricao = '$descricao',
          precoVenda = $precoVenda,
          precoCusto = $precoCusto,
          idMarcaProduto = $idMarca,
          idGrupoProduto = $idGrupo,
          idnAtivo = $idnAtivo
      WHERE id = $id
    ";
  } else {
    $sql = "
      INSERT INTO produto (descricao, precoVenda, precoCusto, idMarcaProduto, idGrupoProduto, idnAtivo)
      VALUES ('$descricao', $precoVenda, $precoCusto, $idMarca, $idGrupo, $idnAtivo)
    ";
  }

  return $conn->query($sql);
}

function excluirProduto($id) {
  global $conn;
  $id = intval($id);
  return $conn->query("DELETE FROM produto WHERE id = $id");
}

function listarMarcas() {
  global $conn;
  $res = $conn->query("SELECT id, descricao FROM marca ORDER BY descricao");
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

function listarGruposProduto() {
  global $conn;
  $res = $conn->query("SELECT id, descricao FROM produto_grupo ORDER BY descricao");
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}