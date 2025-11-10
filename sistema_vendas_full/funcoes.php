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
    header("Location: cadastrar_usuario.php?erro=1");
    exit;
  }

  // Verifica duplicidade
  $check = $conn->query("SELECT id FROM usuario WHERE login = '$login'");
  if ($check && $check->num_rows > 0) {
    header("Location: cadastrar_usuario.php?erro=loginDuplicado");
    exit;
  }

  $senhaMd5 = md5($senha);
  $sql = "INSERT INTO usuario (nome, login, senha, idnAtivo) 
          VALUES ('$nome', '$login', '$senhaMd5', 1)";

  if ($conn->query($sql)) {
    header("Location: index.html?cad=ok");
  } else {
    header("Location: cadastrar_usuario.php?erro=db");
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
    header("Location: index.html?erro=1");
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
    header("Location: usuario.php?msg=ok");
  } else {
    echo "<div class='error'>Erro ao atualizar: {$conn->error}</div>";
  }
  exit;
}

function excluirUsuario() {
  global $conn;
  $id = intval($_POST['id']);
  $conn->query("DELETE FROM usuario WHERE id=$id");
  header("Location: usuario.php?msg=ok");
  exit;
}

function inserirUsuario() {
  global $conn;
  $login = trim($_POST['login']);
  $nome  = trim($_POST['nome']);
  $senha = trim($_POST['senha']);

  if ($login === '' || $nome === '' || $senha === '') {
    header("Location: cadastrar_usuario.php?erro=campos");
    exit;
  }

  $check = $conn->query("SELECT id FROM usuario WHERE login='$login'");
  if ($check && $check->num_rows > 0) {
    header("Location: cadastrar_usuario.php?erro=loginDuplicado");
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