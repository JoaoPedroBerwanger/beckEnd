<?php
        

        foreach($_POST["Processador"] as $CPU)
            {
                echo "- " . $CPU . "<br>";
            }


        if(isset($_POST["Processador"]))
        {
            echo "Os processador são: <br>";

            foreach($_POST["Processador"] as $CPU)
            {
                echo "- " . $CPU . "<br>";
            }
        } else {
            echo "Você não escolheu nenhum livro";
        }
?>
