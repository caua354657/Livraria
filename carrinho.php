<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();

if(!isset($_SESSION['carrinho']))
{
  $_SESSION['carrinho'] = array();
}

if(isset($_GET['acao']))
{
    //adionar livro ao carrinho
   if($_GET['acao'] == 'add')
   {
    $id = $_GET['id'];
    if(!isset($_SESSION['carrinho'][$id]))
      $_SESSION['carrinho'][$id] = 1;
    else
      $_SESSION['carrinho'][$id] += 1;
      header("location: carrinho.php");
   }

  //tirar livro do carrinho
  if($_GET['acao'] == 'dell')
  {
    $id = $_GET['id'];
    unset($_SESSION['carrinho'][$id]);
  }

  //mudar quantidade
  if($_GET['acao'] == 'up')
  {
    if(isset($_POST['prod']))
      if(is_array($_POST['prod']))
      {
        foreach($_POST['prod'] as $id => $qtd)
        {
          if(!empty($qtd) || $qtd <> 0)
            $_SESSION['carrinho'][$id] = $qtd;
          else
            unset($_SESSION['carrinho'][$id]);
        }
      }
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Carrinho</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="container mt-4 mb-5">

<?php
  include_once("conexaoSGBD.php");

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
    echo '<div class="card bg-warning text-center border-black">
            <div class="card-body"><h4><b>🛒 Carrinho</b></h4></div>
          </div><br>';

    echo '<form action="?acao=up" method="post">';
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped table-bordered">
            <thead class="table-dark text-center">
              <tr>
                <th>Capa</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Preço</th>
                <th style="width: 150px;">Quantidade</th>
                <th style="width: 175px;">Subtotal</th>
                <th>Ação</th>
              </tr>
            </thead>';

    $total_compra = 0;     
    foreach($_SESSION['carrinho'] as $id => $qtd) // laço repetição para vetor // $id é o indíce, $qtd é conteúdo //
    {          
      $sql = "select * from livro where id_livro = $id";

      if ($result = $conexao->query($sql)) 
      {
        while($row = $result->fetch_assoc()) 
        {
          $id = $row['id_livro'];
          $sub = $row['preco'] * $qtd;
          $total_compra += $sub;
          echo '<tr>';
            echo '<td class="text-center align-middle"><img src="img/'.$row['imagem'].'" width="80" height="80"></td>';
            echo '<td class="text-center align-middle">'.$row['titulo'].'</td>';
            echo '<td class="text-center align-middle">'.$row['autor'].'</td>';
            echo '<td class="text-center align-middle">R$'.number_format($row['preco'], 2, ',', '.').'</td>';
            echo '<td class="text-center align-middle"><input class="form-control text-center" type="number" name="prod['.$id.']" value="'.$qtd.'" min="0" max="1000" step="1" onchange="validar(this)"></td>';
            echo '<td class="text-center align-middle">R$'.number_format($sub, 2, ',', '.').'</td>';
            echo '<td class="text-center align-middle"><a href="?acao=dell&id='.$id.'" class="btn btn-outline-danger">❌</a></td>';
          echo '</tr>';
        }
      }
    }
    echo '<tr>';
    echo '<td colspan="5" class="text-end fw-bold">Total:</td>';
    echo '<td class="text-center fw-bold">R$'.number_format($total_compra, 2, ',', '.').'</td>';
    echo '<td></td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '</form>';
    echo '<div class="d-flex text-center" style="gap: 25px;">
            <a href="terror.php" class="btn btn-secondary w-50">Continuar Comprando</a>
            <a href="pagamento.php" class="btn btn-success w-50">Ir para Pagamento</a>
          </div>';
    $_SESSION['total'] = $total_compra;
  }
    $conexao->close();
?>

<script scr="js/validar.js"></script>

</div>

</body>
</html>