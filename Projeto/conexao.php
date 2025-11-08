<?php

session_start();

//config da conexão a db
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "consumo_energia";
$connect = mysqli_connect($servername, $username, $password, $db_name);

if (!$connect) {
    die("Erro na conexão: " . mysqli_connect_error());
}

//botão voltar
$btnVoltar = "<button onclick='history.back()'>Voltar</button>";

//switch das acoes
if (isset($_POST["acao"])) {

    switch ($_POST["acao"]) {

        case "entrar":
            entrarSistema();
            break;

        case "cadUsuario":
            inserirUsuario();
            break;

        case "cadCliente":
            inserirCliente();
            break;

        case "logout":
            fazerLogout();
        break;

        case "excluirUsuario":
            excluirUsuario();
        break;

        case "excluirCliente":
            excluirCliente();
        break;

        case "editarCliente":
            atualizarCliente();
        break;

        case "editarUsuario":
            atualizarUsuario();
        break;
    }
}

//funções
function entrarSistema() {

    global $connect, $btnVoltar;

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $senha = mysqli_real_escape_string($connect, $_POST['senha']);

    $sql = "SELECT * FROM usuario WHERE login = '$login'";
    $resultado = mysqli_query($connect, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        $dados = mysqli_fetch_array($resultado);
        $senhaMD5 = md5($senha);

        if ($dados['senha'] === $senhaMD5) {
            $_SESSION['logado'] = true;
            $_SESSION['id_usuario'] = $dados['id'];
            header('Location: home.php');
            exit;
        } else {
            echo "⚠️ Senha incorreta!<br><br>";
            echo $btnVoltar;
        }
    } else {
        echo "⚠️ Usuário inexistente!<br><br>";
        echo $btnVoltar;
    }
}

function fazerLogout() {

    session_start();
    session_unset();
    session_destroy();

    header('Location: index.php');
    exit;
}

function inserirUsuario() {

    global $connect, $btnVoltar;

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $nome  = mysqli_real_escape_string($connect, $_POST['nome']);
    $senha = mysqli_real_escape_string($connect, $_POST['senha']);

    $sqlCheck = "SELECT id FROM usuario WHERE login = '$login'";
    $resultado = mysqli_query($connect, $sqlCheck);

    if (mysqli_num_rows($resultado) > 0) {
        echo "Já existe um usuário com este login, não será possível continuar.<br><br>";
        echo $btnVoltar;
        return;
    }

    $senhaMD5 = md5($senha);

    $sql = "INSERT INTO usuario (
        login, 
        nome, 
        senha) 
        VALUES (
        '$login', 
        '$nome', 
        '$senhaMD5')";

    if (mysqli_query($connect, $sql)) {
        echo "Usuário cadastrado com sucesso!<br><br>";
        echo "<a href='index.php'><button>Efetuar Login</button></a>";
    } else {
        echo "Erro ao cadastrar usuário: " . mysqli_error($connect);
        echo $btnVoltar;
    }
}

function inserirCliente() {

    global $connect, $btnVoltar;

    $nome = mysqli_real_escape_string($connect, $_POST['nome']);
    $sexo = mysqli_real_escape_string($connect, $_POST['sexo']);
    $endereco = mysqli_real_escape_string($connect, $_POST['endereco']);
    $cep = mysqli_real_escape_string($connect, $_POST['cep']);
    $bairro = mysqli_real_escape_string($connect, $_POST['bairro']);
    $cpf = mysqli_real_escape_string($connect, $_POST['cpf']);
    $nascimento = mysqli_real_escape_string($connect, $_POST['nascimento']);
    $data_vencimento = mysqli_real_escape_string($connect, $_POST['data_vencimento']);
    $unidade = mysqli_real_escape_string($connect, $_POST['unidade_consumidora']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $kwh = mysqli_real_escape_string($connect, $_POST['kwh']);
    $valor_total = mysqli_real_escape_string($connect, $_POST['valor_total']);
    $site = mysqli_real_escape_string($connect, $_POST['site']);

    if (empty($nome) || empty($cpf)) {
        echo "Nome e CPF são obrigatórios. $btnVoltar";
        return;
    }

    $sqlCheck = "SELECT id FROM cliente WHERE cpf = '$cpf'";
    $resCheck = mysqli_query($connect, $sqlCheck);
    if (mysqli_num_rows($resCheck) > 0) {
        echo "Já existe um cliente com este CPF. $btnVoltar";
        return;
    }

    $sql = "INSERT INTO cliente (
        nome, 
        sexo, 
        endereco, 
        cep, 
        bairro, 
        cpf, 
        nascimento, 
        data_vencimento, 
        unidade_consumidora, 
        email, 
        kwh, 
        valor_total, 
        site) VALUES
        ('$nome', 
        '$sexo', 
        '$endereco', 
        '$cep', 
        '$bairro', 
        '$cpf', 
        '$nascimento', 
        '$data_vencimento', 
        '$unidade', 
        '$email', 
        '$kwh', 
        '$valor_total', 
        '$site')";

    if (mysqli_query($connect, $sql)) {
        echo "Cliente cadastrado com sucesso!<br><br>";
        echo "<a href='home.php'><button>Voltar ao Menu</button></a>";
    } else {
        echo "Erro ao cadastrar cliente: " . mysqli_error($connect);
        echo $btnVoltar;
    }
}

function obterRelatorioConsumo() {
    global $connect;

    $sql = "SELECT nome, cpf, kwh, valor_total 
            FROM cliente 
            ORDER BY kwh DESC";

    $resultado = mysqli_query($connect, $sql);
    $dados = [];

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
    }

    return $dados;
}

function obterRelatorioVencimento() {
    global $connect;

    $sql = "SELECT nome, cpf, data_vencimento, valor_total
            FROM cliente
            ORDER BY data_vencimento DESC";

    $resultado = mysqli_query($connect, $sql);
    $dados = [];

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
    }

    return $dados;
}

function consultarUsuarios() {
    global $connect;

    $sql = "SELECT * FROM usuario ORDER BY id";
    $resultado = mysqli_query($connect, $sql);
    $dados = [];

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
    }
    return $dados;
}

function consultarClientes() {
    global $connect;

    $sql = "SELECT * FROM cliente ORDER BY id";
    $resultado = mysqli_query($connect, $sql);
    $dados = [];

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
    }
    return $dados;
}

function excluirCliente() {
    global $connect;

    $id = intval($_POST['id']);
    $sql = "DELETE FROM cliente WHERE id = $id";

    if (mysqli_query($connect, $sql)) {
        echo "Cliente excluído com sucesso!<br><br>";
        echo "<a href='consultarClientes'><button>Voltar à lista</button></a>";
    } else {
        echo "Erro ao excluir cliente: " . mysqli_error($connect);
    }
}

function excluirUsuario() {
    global $connect;

    $id = intval($_POST['id']);
    $sql = "DELETE FROM usuario WHERE id = $id";

    if (mysqli_query($connect, $sql)) {
        echo "Usuário excluído com sucesso!<br><br>";
        echo "<a href='consultarUsuarios.php'><button>Voltar à lista</button></a>";
    } else {
        echo "Erro ao excluir usuário: " . mysqli_error($connect);
    }
}

function selecionarUsuarioId($id) {
    global $connect;
    $sql = "SELECT * FROM usuario WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    return mysqli_fetch_assoc($result);
}

function selecionarClienteId($id) {
    global $connect;
    $sql = "SELECT * FROM cliente WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    return mysqli_fetch_assoc($result);
}

function atualizarUsuario() {
    global $connect;

    $id = intval($_POST["id"]);
    $login = mysqli_real_escape_string($connect, $_POST["login"]);
    $nome = mysqli_real_escape_string($connect, $_POST["nome"]);
    $senha = mysqli_real_escape_string($connect, $_POST["senha"]);

    if (!empty($senha)) {
        $senhaCript = md5($senha);
        $sql = "UPDATE usuario SET login='$login', nome='$nome', senha='$senhaCript' WHERE id=$id";
    } else {
        $sql = "UPDATE usuario SET login='$login', nome='$nome' WHERE id=$id";
    }

    if (mysqli_query($connect, $sql)) {
        header("Location: consultarUsuarios.php?msg=editado");
        exit;
    } else {
        echo "Erro ao atualizar usuário: " . mysqli_error($connect);
    }
}

function atualizarCliente() {
    global $connect;

    $id = intval($_POST["id"]);
    $nome = mysqli_real_escape_string($connect, $_POST["nome"]);
    $sexo = mysqli_real_escape_string($connect, $_POST["sexo"]);
    $endereco = mysqli_real_escape_string($connect, $_POST["endereco"]);
    $cep = mysqli_real_escape_string($connect, $_POST["cep"]);
    $bairro = mysqli_real_escape_string($connect, $_POST["bairro"]);
    $cpf = mysqli_real_escape_string($connect, $_POST["cpf"]);
    $nascimento = mysqli_real_escape_string($connect, $_POST["nascimento"]);
    $data_vencimento = mysqli_real_escape_string($connect, $_POST["data_vencimento"]);
    $unidade = mysqli_real_escape_string($connect, $_POST["unidade_consumidora"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $kwh = mysqli_real_escape_string($connect, $_POST["kwh"]);
    $valor_total = mysqli_real_escape_string($connect, $_POST["valor_total"]);
    $site = mysqli_real_escape_string($connect, $_POST["site"]);

    $sql = "UPDATE cliente SET 
                nome='$nome',
                sexo='$sexo',
                endereco='$endereco',
                cep='$cep',
                bairro='$bairro',
                cpf='$cpf',
                nascimento='$nascimento',
                data_vencimento='$data_vencimento',
                unidade_consumidora='$unidade',
                email='$email',
                kwh='$kwh',
                valor_total='$valor_total',
                site='$site'
            WHERE id=$id";

    if (mysqli_query($connect, $sql)) {
        header("Location: consultarClientes.php?msg=editado");
        exit;
    } else {
        echo "Erro ao atualizar cliente: " . mysqli_error($connect);
    }
}

?>
