<?php
include "conexao.php";
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['usuario_id'])) {
  header("Location: index.html");
  exit;
}

// Inserir nova marca
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["descricao"])) {
  $descricao = trim($_POST["descricao"]);
  if ($descricao !== "") {
    $stmt = $conn->prepare("INSERT INTO marca (descricao) VALUES (?)");
    $stmt->bind_param("s", $descricao);
    $stmt->execute();
  }
  header("Location: marca.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Marcas</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
<div class="wrap">
  <h2>Cadastro de Marcas</h2>

  <form method="POST" action="">
    <label>Descrição:</label>
    <input type="text" name="descricao" required>
    <button type="submit">Salvar</button>
  </form>

  <h3>Marcas Cadastradas</h3>
  <table>
    <tr><th>ID</th><th>Descrição</th></tr>
    <?php
    $res = $conn->query("SELECT * FROM marca ORDER BY id");
    while ($row = $res->fetch_assoc()) {
      echo "<tr><td>{$row['id']}</td><td>{$row['descricao']}</td></tr>";
    }
    ?>
  </table>

  <a class="back" href="home.php">⟵ Voltar ao Menu</a>
</div>
</body>
</html>
