<?php

    if (isset($_GET["nome"])) {
        echo "Olá, " . $_GET["nome"];
    } else {
        echo "Nenhum nome foi enviado.";
    }

?>