<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();

if(!isset($_SESSION['favoritos']))
{
    $_SESSION['favoritos'] = array();
}

if(isset($_GET['acoes']))
{
    //favoritar livro
    if($_GET['acoes'] == 'favoritar')
    {
        $id = $_GET['id'];
        if(!isset($_SESSION['favoritos'][$id]))
            $_SESSION['favoritos'][$id] = 1;
        else
            $_SESSION['favoritos'][$id] += 1;
            header("location: meus_favoritos.php");
    }

    if($_GET['acoes'] == 'tirar')
    {
      $id = $_GET['id'];
      unset($_SESSION['favoritos'][$id]);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meus Favoritos</title>
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/meus_favoritos.css">
</head>
<body>

<div class="container mt-4">

<?php
  include_once("conexaoSGBD.php");

  if(count($_SESSION['favoritos']) == 0)
  {
    echo '<div class="alert alert-danger text-center" role="alert">
            <h4><b>Nenhum livro Favoritado</b></h4>
            <h6>Aguarde redirecionar...</h6>
          </div>';
    header("refresh: 2; url=index.php");
  }
  else
  { 
  echo '<div class="card">
          <div class="header-titulo d-flex justify-content-center align-items-center" style="height: 80px;">
            <h4>❤️ Meus Favoritos</h4>
          </div>
          <div class="conteudo-fundo">
              <div class="text-start p-3">
                <a href="terror.php" class="btn btn-secondary">Voltar</a>
              </div>';

    echo '<div class="container livros-container my-4">';
    echo '<div class="row g-4">';
    foreach($_SESSION['favoritos'] as $id => $qtd) // laço repetição para vetor // $id é o indíce, $qtd é conteúdo //
    {          
      $sql = "select * from livro where id_livro = $id";

      if($result = $conexao->query($sql)) 
      {
        while($row = $result->fetch_assoc()) 
        {
          $id = $row['id_livro'];
          echo '<div class="col-6 col-md-4 d-flex justify-content-center">
                <div class="card" style="width: 275px;">
                  <div class="d-flex justify-content-center align-items-center card-body btn btn-danger" style="position: absolute; width: 45px; height: 45px;">
                    <a href="meus_favoritos.php?acoes=tirar&id='.$id.'" class="nav-link" style="cursor: pointer; font-size: 30px;">❌</a>
                  </div>
                  <div class="d-flex justify-content-center align-items-center card-body btn btn-dark" style="position: absolute; top: 0; right: 0; width: 45px; height: 45px;">
                    <a href="carrinho.php?acao=add&id='.$id.'" class="nav-link" style="cursor: pointer; font-size: 30px;">🛒</a>
                  </div>
                  <img src="capa_livro/'.$row['imagem'].'" class="card-img-top" style="width: 100%; height: 200px; object-fit: cover;">
                  <div class="card-body">
                    <h4 class="card-title">'.$row['titulo'].'</h4>
                    <p class="card-text mb-1 text-muted">'.$row['autor'].'</p>
                    <p class="card-text fw-bold" style="color: rgb(159, 133, 28)">R$'.number_format($row['preco'], 2, ',', '.').'</p>
                    <div class="d-flex">
                      <a href="carrinho.php?acao=add&id='.$id.'" class="btn btn-success w-100">Comprar</a>
                    </div>
                  </div>
                </div>
            </div>';
        }
      }
    }
    echo '</div>';
    echo '</div>';
  }
    $conexao->close();
    
?>

        </div>
    </div>
</div>
    
</body>
</html>