<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Histórico Compras</title>
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">

<?php
    include_once("conexaoSGBD.php");
    $id = $_SESSION['id_cliente'];

    $sql = "select * from vendas_produto join vendas on vendas_produto.id_venda = vendas.id_venda where vendas.id_cliente = $id";

    if($dados = $conexao->query($sql))
    {
        $total_compras = $dados->num_rows;

        if($total_compras > 0)
        {
          echo '<div class="card bg-primary text-center text-white">
                  <div class="card-body fs-5"><b>🛍️ Histórico Compras</b></div>
                </div>';
          echo '<br>';
          echo '<a href="index.php" class="btn btn-secondary">Voltar</a>';
          echo '<div class="table-responsive">
                  <table class="table-striped table table-bordered table-hover mt-4">
                      <thead class="text-center">
                        <tr>
                          <th>ID</th>
                          <th>ID_Venda</th>
                          <th>Data</th>
                          <th>Hora</th>
                          <th>Pagamento</th>
                          <th>ID_Livro</th>
                          <th>Preço</th>
                          <th>Quantidade</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody class="text-center">';
        
            while($linha = $dados->fetch_assoc())
            {
              echo '<tr>
                      <td>'.$linha['id_venda_produto'].'</td>
                      <td>'.$linha['id_venda'].'</td>
                      <td>'.date("d/m/Y", strtotime($linha['data'])).'</td>
                      <td>'.$linha['hora'].'</td>
                      <td>'.$linha['forma_pgto'].'</td>
                      <td>'.$linha['id_livro'].'</td>
                      <td>R$'.number_format($linha['preco_unitario'], 2, ',', '.').'</td>
                      <td>'.$linha['quantidade'].'</td>
                      <td>R$'.number_format($linha['total_livro'], 2, ',', '.').'</td>
                    </tr>';
            }
              echo '</tbody>
                    </table>
                    </div>';
        }
        else
        {
            echo '<div class="alert alert-danger text-center" role="alert">
                    <h4><b>🛍️ Nenhuma Compra Realizada</b></h4>
                    <h6>Aguarde redirecionar...</h6>
                  </div>';
            header("refresh: 2; url=index.php");
        }
    }
    else
      echo 'Erro ao executar a consulta. '.$conexao->error;
    $conexao->close();
?>

</div>
    
</body>
</html>