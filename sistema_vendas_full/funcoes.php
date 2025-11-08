<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"])) {
  switch ($_POST["acao"]) {
    case "entrar":
      entrarSistema();
      break;
    case "logout":
      fazerLogout();
      break;
    default:
      header("Location: index.html");
      exit;
  }
} else {
  header("Location: index.html");
  exit;
}

function entrarSistema()
{
  global $conn;

  $login = isset($_POST['login']) ? trim($_POST['login']) : "";
  $senha = isset($_POST['senha']) ? trim($_POST['senha']) : "";

  // 🚨 valida se os campos vieram vazios
  if ($login === "" || $senha === "") {
    header("Location: index.html?erro=1");
    exit;
  }

  $senhaMd5 = md5($senha);

  $stmt = $conn->prepare("SELECT id, nome, login FROM usuario WHERE login = ? AND senha = ? AND idnAtivo = 1");
  $stmt->bind_param("ss", $login, $senhaMd5);
  $stmt->execute();
  $res = $stmt->get_result();

  // 🚨 se não encontrou nenhum usuário
  if (!$res || $res->num_rows === 0) {
    header("Location: index.html?erro=1");
    exit;
  }

  // ✅ login correto
  $u = $res->fetch_assoc();
  $_SESSION['usuario_id'] = $u['id'];
  $_SESSION['usuario_nome'] = $u['nome'];
  $_SESSION['usuario_login'] = $u['login'];

  header("Location: home.php");
  exit;
}

function fazerLogout()
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  session_unset();
  session_destroy();
  header("Location: index.html");
  exit;
}
