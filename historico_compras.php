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
<body style="background-color: rgba(213, 207, 207, 1)">

<div class="container mt-3">

<?php
    include_once("conexaoSGBD.php");
    $id = $_SESSION['id_cliente'];

    $sql = "select * from vendas_produto join vendas on vendas_produto.id_venda = vendas.id_venda where vendas.id_cliente = $id order by vendas.id_venda desc limit 50";

    if($dados = $conexao->query($sql))
    {
        $total_compras = $dados->num_rows;

        if($total_compras > 0)
        {
          echo '<div class="d-flex justify-content-center">
                  <div class="card border-0 rounded-4 bg-primary text-white" style="max-width: 550px; width: 100%;">
                    <div class="card-body fs-4 d-flex justify-content-between">
                    <b>🛍️ Histórico de Compras</b>
                    <a href="index.php" class="btn btn-secondary">Voltar</a>
                  </div>
                  </div>
                </div>
                <br><br>';
        
            while($linha = $dados->fetch_assoc())
            {
              echo '<div class="d-flex justify-content-center align-items-center mb-4">
                      <div class="card" style="width: 550px">
                        <div class="bg-success border-black">
                          <div class="d-flex card-body text-white">
                            <h4>#'.$linha['id_venda'].'</h4>
                            <div class="ms-auto">
                              <p>'.date("d/m/Y", strtotime($linha['data'])).'</p>
                            </div>
                          </div>
                        </div>
                        <div class="card-body bg-black">
                          <div class="d-flex">
                            <h6 class="card-title text-danger"><b>Item '.$linha['id_venda_produto'].'</b></h6>
                            <h6 class="card-title ms-auto text-white">'.$linha['hora'].'</h6>
                          </div>
                          <div class="text-white">
                            <h6 class="card-text">Pagamento: '.$linha['forma_pgto'].'</h6>
                            <h6 class="card-text">ID_Livro: '.$linha['id_livro'].'</h6>
                            <h6 class="card-text">Unidade: R$'.number_format($linha['preco_unitario'], 2, ',', '.').'</h6>
                            <h6 class="card-text">Quantidade: '.$linha['quantidade'].'</h6>
                            <h6 class="card-text">Total: R$'.number_format($linha['total_livro'], 2, ',', '.').'</h6>
                          </div>
                        </div>
                      </div>
                    </div>';
            }
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