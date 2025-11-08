<?php

    $login = isset($_POST["user"]) ? $_POST["user"] : "";
    $senha = isset($_POST["senha"]) ? $_POST["senha"] : "";

    if ($login == "admin") {
        if($senha == "1234")
            echo "Bem-Vindo!";
        else
            echo "Senha incorreta.";
    } else {
        echo "Login incorreto.";
    }

?>