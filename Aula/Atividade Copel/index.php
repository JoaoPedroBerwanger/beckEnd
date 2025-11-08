
<?php include 'conexaoCopel.php';
$grupo=listarUsuarios();
?>


<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1> Dados Formulario </h1>
<a href="inserir.php"> Adicionar Dados</a>

<table border="1">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Sexo</th>
        <th>Endereço</th>
        <th>CEP</th>
        <th>Bairro</th>
        <th>CPF</th>
        <th>Data de Nascimento</th>
        <th>Data do Vencimento</th>
        <th>Un. Consumidora</th>
        <th>KW/h</th>
        <th>Valor Total</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($grupo as $usuario) {?>
        <tr>
            <td><?=$usuario["nome"]?></td>
            <td><?=$usuario["sexo"]?></td>
            <td><?=$usuario["endereco"]?></td>
            <td><?=$usuario["cep"]?></td>
            <td><?=$usuario["bairro"]?></td>
            <td><?=$usuario["cpf"]?></td>
            <td><?=$usuario["nascimento"]?></td>
            <td><?=$usuario["vencimento"]?></td>
            <td><?=$usuario["unConsumidora"]?></td>
            <td><?=$usuario["kwh"]?></td>
            <td><?=$usuario["valorTotal"]?></td>
            <th>
                <form name="alterar" action="alterarDados.php" method="POST">
                    <input type="hidden" name="id" value=<?=$usuario["id"]?> />
                    <input type="submit" value="Editar" name="editar" />

                </form>

            </th>
            <th>
                <form name="excluir" action="conexaoCopel.php" method="POST">
                    <input type="hidden" name="id" value=<?=$usuario["id"]?> />
                    <input type="hidden" name="acao" value="excluir" />
                    <input type="submit" value="Excluir" name="excluir" />
                </form>
            </th>
        </tr>
    <?php }
    ?>

    </tbody>
</table>




</body>
</html>
