<?php
$conn = new mysqli('localhost', 'root', '', 'vendas');

if ($conn->connect_error) {
    die("Conexão com banco falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado corretamente
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['produto_id'], $_POST['usuario_id'], $_POST['preco_produto'], $_POST['quantidade'], $_POST['total'], $_POST['condicao_pagamento'])) {
    die("Erro ao enviar os dados.");
}

// Recebe os dados do formulário
$produto_id = $_POST['produto_id'];
$usuario_id = $_POST['usuario_id'];
$preco_produto = $_POST['preco_produto'];
$quantidade = $_POST['quantidade'];
$total = $_POST['total'];
$condicao_pagamento = $_POST['condicao_pagamento'];

// Insere a venda na tabela 'venda'
$sql_venda = "INSERT INTO venda (produto_id, usuario_id, preco_produto, quantidade, total, condicao_pagamento) 
              VALUES ($produto_id, $usuario_id, $preco_produto, $quantidade, $total, '$condicao_pagamento')";

if ($conn->query($sql_venda) === TRUE) {
    // Pega o ID da venda inserida
    $venda_id = $conn->insert_id;

    // Se for parcelado, cria as parcelas
    if ($condicao_pagamento === 'parcelado' && isset($_POST['parcelas'])) {
        $parcelas = $_POST['parcelas'];
        $valor_parcela = $total / $parcelas;

        for ($i = 1; $i <= $parcelas; $i++) {
            $vencimento = new DateTime();
            $vencimento->modify("+$i month");
            $data_vencimento = $vencimento->format('Y-m-d');

            // Insere as parcelas na tabela 'parcelas'
            $sql_parcela = "INSERT INTO parcela (venda_id, numero_parcela, valor, vencimento) 
                            VALUES ($venda_id, $i, $valor_parcela, '$data_vencimento')";
            $conn->query($sql_parcela);
        }
    }

    // Redireciona para a página de sucesso ou PDF
    header('Location: vendas.php'); // Ou você pode gerar o PDF aqui mesmo, dependendo do que deseja
    exit();
} else {
    echo "Erro ao salvar venda: " . $conn->error;
}
?>
