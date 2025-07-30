<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();

if(!isset($_SESSION['carrinho']))
{
    $_SESSION['carrinho'] = array();
    header("location: index.php");
}

if(!isset($_SESSION['id_cliente']))
{
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Finalizando Compra</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/finalizar_compra.css">
</head>
<body>

<div class="container">
        
<?php
    if(count($_SESSION['carrinho']) == 0)
    {
        echo '<div class="alert alert-danger text-center" role="alert">
                <h4><b>🛒 Carrinho Vazio</b></h4>
                <h6>Aguarde redirecionar...</h6>
              </div>';
        header("refresh: 2; url=index.php");
    }
    else
    {
        include_once("conexaoSGBD.php");
        $total_compra = 0;

        if(!empty($_POST['pagamento']))
            $forma_pgto = $_POST['pagamento'];
        else
            $forma_pgto = "";

        $livros_comprado = count($_SESSION['carrinho']);
        $total_compra = $_SESSION['total'];
        $id_cliente = $_SESSION['id_cliente'];

        $sql_vendas = "insert into vendas(livros_comprado, total_compra, data, hora, forma_pgto, id_cliente) values('$livros_comprado', '$total_compra', current_date, current_time, '$forma_pgto', '$id_cliente')";
        $result = $conexao->query($sql_vendas);
        $id_venda = $conexao->insert_id; //pega o ultimo id cadastrado no banco dados

        //inserindo os livros da compra do carrinho
        $total_quantidade = 0;
        foreach($_SESSION['carrinho'] as $id => $qtd)
        {
            $sql = "select * from livro where id_livro = $id";
            $dados = $conexao->query($sql);
            $linha = $dados->fetch_assoc();
            $id_livro = $linha["id_livro"];
            $quantidade = $qtd;
            $preco_unitario = $linha['preco'];
            $total_livro = $preco_unitario * $qtd;
            
            $total_quantidade = $total_quantidade + $qtd;
            $total = $total_compra + $total_livro;
                                                                                                                                                                                    //linha 57
            $sql_vendas_produtos = "insert into vendas_produto(id_livro, quantidade, preco_unitario, id_venda, total_livro) values('$id_livro', '$quantidade', '$preco_unitario', '$id_venda', '$total_livro')";
            $qtd = $conexao->query($sql_vendas_produtos);
        }
        
        $sql_update = "update vendas set total_compra = $total_compra, livros_comprado = $total_quantidade where id_venda = $id_venda";
        $qtd = $conexao->query($sql_update);

        unset($_SESSION['carrinho']);

        echo '<div class="container my-5">
                <div class="card shadow-lg">
                    <div class="card-header bg-danger text-white text-center fs-5 fw-semibold">Compra realizada com sucesso!</div>
                        <div class="card-body text-center">
                            <p>Compra Número: <b>'.$id_venda.'</b></p>
                            <p>Total da Compra: <b>R$ '.number_format($total_compra, 2, ',', '.').'<b></p>
                            <div class="d-flex gap-2">
                                <a href="index.php" type="button" class="w-50">Página Inicial</a>
                                <a href="historico_compras.php" type="button" class="w-50">Histórico Compra</a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>';
    }
    $conexao->close();
?>

</body>
</html>