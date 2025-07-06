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
        require_once("conexaoSGBD.php");
        $total = 0;

        if(!empty($_POST['forma']))
            $forma_pg = $_POST['forma'];
        else
            $forma_pg = "";

        $id_cliente = $_SESSION['id_cliente'];
        $sql_vendas = "insert into vendas(data_emissao, hora, forma_pgto, id_cliente) values(current_date, current_time, '$forma_pg', '$id_cliente')";
        $result = $conexao->query($sql_vendas);
        $id_venda = $conexao->insert_id;

        //inserindo os itens da venda do carrinho 
        $total_qtd = 0;
        foreach($_SESSION['carrinho'] as $id => $qtd)
        {
            $sql = "select * from livro where id_livro = $id";
            $dados = $conexao->query($sql);
            $linha = $dados->fetch_assoc();
            $id_produto = $linha["id_livro"];
            $preco_unitario = $linha['preco'];
            $total_item = $preco_unitario * $qtd; 
            $total_qtd = $total_qtd + $qtd;
            $total = $total + $total_item;

            $sql = "insert into vendas_item(id_livro, quantidade, preco_unitario, id_vendas, total_item) values('$id_produto', '$qtd', '$preco_unitario', '$id_venda', '$total_item')";
            $qtd = $conexao->query($sql);

        }
        
        $sql = "update vendas set total_nota = $total, numero_itens = $total_qtd where id_vendas = $id_venda";

        $qtd = $conexao->query($sql);
        unset($_SESSION['carrinho']);

        echo "<h1>Compra realizada com sucesso!<br>Compra Número: $id_venda</h1><br>";
        echo '<h1>Total da Compra: R$ '.number_format($total, 2, ',', '.').'</h1><br>';
        echo "<a href=pedidos.php?idcliente=".$id_cliente.">Meus Pedidos</a>";
    }

?>

</body>
</html>