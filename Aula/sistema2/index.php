
<?php include 'conexao.php';
$grupo=listarUsuarios();
//var_dump($grupo);
?>


<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1> Dados Formulario </h1>
<a href="inserir.php"> Adicionar Cliente</a>

<table border="1">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Nascimento</th>
        <th>Endereço</th>
        <th>Bairro</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($grupo as $usuario) {?>
        <tr>
            <td><?=$usuario["nome"]?></td>
            <td><?=$usuario["nascimento"]?></td>
            <td><?=$usuario["endereco"]?></td>
            <td><?=$usuario["bairro"]?></td>
            <th>
                <form name="alterar" action="alterar.php" method="POST">
                    <input type="hidden" name="id" value=<?=$usuario["id"]?> />
                    <input type="submit" value="Editar" name="editar" />

                </form>

            </th>
            <th>
                <form name="excluir" action="conexao.php" method="POST">
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
