<?php

    $dataHoje = new DateTime();
    $datanascimento = isset($_POST["dataNascimento"]) ? $_POST["dataNascimento"] : "";

    if(!empty($datanascimento))
    {
        $dataNascimentoFormatada = DateTime::createFromFormat('Y-m-d', $datanascimento);

        if($dataNascimentoFormatada)
        {
            $idade = $dataNascimentoFormatada->diff($dataHoje);
        
            echo "Idade: " . $idade->y;
        }
    } else
    {
        echo "Data de nascimento não informada.";
    }
?>