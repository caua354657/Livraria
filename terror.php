<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Terror</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="css/terror.css">
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container">
    <a href="index.php"><img src="img/Logo.png" class="rounded-circle" width="80" height="80"></a>
        
<?php 
    include_once("conexaoSGBD.php");
    
    if(isset($_SESSION['nome'])) 
      echo '<div class="ms-auto">
              <a href="#" class="btn btn-outline-info btn-sm" data-bs-toggle="offcanvas" data-bs-target="#demo"><b>🙎🏽‍♂️ Conta</b></a>
            </div>';
    else 
      echo '<div class="d-flex ms-auto align-items-center">
              <a href="login.php" class="btn btn-outline-info btn-sm me-2">🙎🏽‍♂️ Login</a>
              <a href="cadastro_cliente.php" class="btn btn-outline-info btn-sm">🙎🏽‍♂️ Cadastrar</a>
            </div>';
?>

  </div>
</nav>

<?php
   if(isset($_SESSION['id_cliente']))
   {
    $id = $_SESSION['id_cliente'];

    $sql = "select foto_perfil from cliente where id_cliente = $id";

    if ($result = $conexao->query($sql)) 
    {
      if($linha = $result->fetch_assoc()) 
        $foto = $linha['foto_perfil'];
    }
   }
?>

<?php
   $sql = "select id_notificacao, count(*) from notificacoes";

   if($dados = $conexao->query($sql)) 
   {
      $totalnotificacoes = $dados->num_rows;

      if($totalnotificacoes > 0) 
      {
         $row = $dados->fetch_assoc();
         $totalnotificacoes = $row['count(*)'];
      }
   } 
   else 
      echo 'Erro: '.$conexao->error;
?>

<?php 
    if (isset($_SESSION['nome'])) 
    {
    echo'<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 " tabindex="-1" id="demo" style="width: 300px; height: 100%;">
            <div class="d-flex">
              <img src="img/Logo.png" width="80" height="80" class="rounded-circle me-2" style="border: 1px solid black;">
              <span class="d-flex justify-content-center align-items-center"><h4>Book Tree</h4></span>
              <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas"></button>
            </div>
          <hr>
              <ul class="list-group flex-column mb-auto">
                  <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="meus_livros.php">📙 Meus Livros</a></li>
                  <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="carrinho.php">🛒 Carrinho</a></li>
                  <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="meus_favoritos.php">❤️ Meus Favoritos</a></li>'; 
                  if($_SESSION['adm'] == 'admin')
                     echo'<li class="list-group-item d-flex" style="border: none;"><a class="dropdown-item" href="notificacoes.php">🔔 Notificações</a><span class="badge bg-success">'.$totalnotificacoes.'</span></li>
                          <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="gerenciar_usuario.php">🙎🏽‍♂️ Gerenciar Usuários</a></li>
                          <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="gerenciar_livros.php">📚 Gerenciar Livros</a></li>
                          <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="gerenciar_categorias.php">🏷️ Gerenciar Categorias</a></li>';
                  else
                    echo '<li class="list-group-item d-flex" style="border: none;"><a class="dropdown-item" href="sugestoes.php">💡 Sugestões para o Site</a></li>';       
          echo '</ul>
          <hr>
          <div class="dropdown d-flex">
            <img src="foto_perfil/'.$linha['foto_perfil'].'" width="50" height="50" class="me-2" style="border: 1px solid black;">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false" style="max-width: 200px; white-space: normal; word-break: break-word;">
              <strong>'.$_SESSION['nome'].'</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
              <li class="menu-item text-center"><a class="dropdown-item" href="configuracoes.php">⚙️ Configurações</a></li>
              <li class="menu-logout text-center"><a class="dropdown-item text-danger" href="logout.php">Sair</a></li>
            </ul>
          </div>
        </div>';
    }
?>

<?php
      $sql = "select descricao, destino from categoria";

      if($resultado = $conexao->query($sql))
      {
        echo'<div style="background-color: black; overflow-x: auto;">
             <ul class="nav nav-pills" style="display: flex; justify-content: center; flex-wrap: nowrap; min-width: max-content;">';

        while($line = $resultado->fetch_assoc())
        {
           $categoria = $line['descricao'];
           $pagina = $line['destino'];
           echo '<li class="nav-item">
                   <a class="nav-link text-white" id="navlink" href="'.$pagina.'">'.$categoria.'</a>
                 </li>';
        }
          echo '</ul>
                </div>';
      }
?>

    <br>
    <h2 class="text-center mb-4 titulo-animado">👹 Terror</h2>
    <div class="d-flex justify-content-center align-items-center px-5">
      <form action="#" method="GET" class="search-form w-100" style="max-width: 500px;">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Pesquisar..." name="livro">
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </form>
    </div>
    <br>

<?php

if(isset($_GET['livro']))
    $livro = $_GET['livro'];
else
    $livro = '';

$sql = "select * from livro where id_categoria = 1 and titulo like '%$livro%' order by rand() limit 12";

if ($result = $conexao->query($sql)) 
{
    echo '<div class="container livros-container my-4">';
    echo '<div class="row g-4">';

    while($row = $result->fetch_assoc()) 
    {
        $id = $row['id_livro'];
        $arquivo = $row['pdf'];
        echo '<div class="col-6 col-md-4 d-flex justify-content-center">
                <div class="card" style="width: 275px;">
                  <div class="d-flex justify-content-center align-items-center card-body btn btn-danger" style="position: absolute; width: 45px; height: 45px;">
                    <a href="meus_favoritos.php?acoes=favoritar&id='.$id.'" class="nav-link" style="cursor: pointer; font-size: 30px;">❤️</a>
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
                      <a href="pdf_livro/'.$arquivo.'" class="btn btn-outline-primary w-50 me-2" download>⬇️ PDF</a>
                      <a href="carrinho.php?acao=add&id='.$id.'" class="btn btn-success w-50">Comprar</a>
                    </div>
                  </div>
                </div>
            </div>';
    }

    echo '</div>';
    echo '</div>';
}
    $conexao->close();
?>

<br><br>

<div class="footer-clean">
        <footer>
            <div class="container">
                <div class="row justify-content-center" id="container-footer">
                    <div class="row justify-content-center" id="container-footer">
                      <div class="col-12 col-md-4 item mb-4">
                        <h3>🏠 Sobre</h3>
                          <h6 style="text-align: left; color: rgb(123, 173, 94)">
                            Na Book Tree, acreditamos que um bom livro pode mudar o mundo. 
                            E que uma boa leitura começa com uma escolha feita com o coração.🌱 Venha crescer com a gente.📘 Leia. Sinta. Compartilhe.
                          </h6>
                      </div>
                      <div class="col-12 col-md-8">
                        <div class="row">
                          <div class="col-6 col-md-6 item mb-4">
                            <h3>ℹ️ Informações</h3>
                            <ul>
                              <li><a href="https://workspace.google.com/intl/pt-BR/gmail/" target="_blank" id="linkfooter">booktree@gmail.com</a></li>
                              <li><a href="#" id="linkfooter">Política Privacidade</a></li>
                              <li><a href="#" id="linkfooter" >Termos Uso</a></li>
                            </ul>
                          </div>
                          <div class="col-6 col-md-6 item mb-4">
                            <h3>🖱️ Atalhos</h3>
                            <ul>
                              <li><a href="#" id="linkfooter">Home</a></li>
                              <li><a href="terror.php" id="linkfooter">Loja</a></li>
                              <li><a href="login.php" id="linkfooter">Login</a></li>
                              <li><a href="cadastro_cliente.php" id="linkfooter">Cadastro</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <hr class="item" style="border-color: rgb(255, 255, 255);">
                    <div class="wrapper d-flex justify-content-center">
                        <div class="icon facebook">
                          <div class="tooltip">Facebook</div>
                          <a href="https://www.facebook.com/?locale=pt_BR" target="blank">
                            <span><i class="fab fa-facebook-f"></i></span>
                          </a>
                        </div>
                        <div class="icon twitter">
                          <div class="tooltip">Twitter</div>
                          <a href="https://x.com/" target="blank">
                            <span><i class="fab fa-twitter"></i></span>
                          </a>
                        </div>
                        <div class="icon instagram">
                          <div class="tooltip">Instagram</div>
                          <a href="https://www.instagram.com/" target="blank">
                            <span><i class="fab fa-instagram"></i></span>
                          </a>
                        </div>
                        <div class="icon github">
                          <div class="tooltip">Github</div>
                          <a href="https://github.com/" target="blank">
                            <span><i class="fab fa-github"></i></span>
                          </a>
                        </div>
                        <div class="icon youtube">
                          <div class="tooltip">YouTube</div>
                          <a href="https://www.youtube.com/" target="blank">
                            <span><i class="fab fa-youtube"></i></span>
                          </a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="https://wa.me/551112345678" target="_blank" class="whatsapp-button" style="position: fixed; bottom: 20px; right: 20px; z-index: 999; background-color: #25D366; border-radius: 50%; padding: 12px; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
              <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="28" height="28">
            </a>
        </footer>
</div>

</body>
</html>