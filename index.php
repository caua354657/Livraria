<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Book Tree</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="css/index.css">
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
   $sql = "select count(*) from notificacoes";

   if($dados = $conexao->query($sql)) 
   {
      $totalnotificacoes = $dados->num_rows;

      if ($totalnotificacoes > 0) 
      {
         $row = $dados->fetch_assoc();
         $totalnotificacoes = $row['count(*)'];
      }
   } 
   else 
      echo 'Erro: '.$conexao->error;
?>

<?php 
    if(isset($_SESSION['nome'])) 
    {
    echo'<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 " tabindex="-1" id="demo" style="width: 300px; height: 100%;">
            <div class="d-flex">
              <img src="img/Logo.png" width="80" height="80" class="rounded-circle me-2" style="border: 1px solid black;">
              <span class="d-flex justify-content-center align-items-center"><h4>Book Tree</h4></span>
              <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas"></button>
            </div>
          <hr>
              <ul class="list-group flex-column mb-auto">
                  <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="carrinho.php">🛒 Carrinho</a></li>
                  <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="historico_compras.php">🛍️ Histórico Compras</a></li>
                  <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="meus_favoritos.php">❤️ Meus Favoritos</a></li>'; 
                  if(isset($_SESSION['adm']))
                  {
                    if($_SESSION['adm'] == 'admin')
                      echo'<li class="list-group-item d-flex" style="border: none;"><a class="dropdown-item" href="notificacoes.php">🔔 Notificações</a><span class="badge bg-success">'.$totalnotificacoes.'</span></li>
                            <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="gerenciar_usuario.php">🙎🏽‍♂️ Gerenciar Usuários</a></li>
                            <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="gerenciar_livros.php">📚 Gerenciar Livros</a></li>
                            <li class="list-group-item" style="border: none;"><a class="dropdown-item" href="gerenciar_categorias.php">🏷️ Gerenciar Categorias</a></li>';
                    else
                      echo '<li class="list-group-item d-flex" style="border: none;"><a class="dropdown-item" href="sugestoes.php">💡 Sugestões para o Site</a></li>';       
                  }
          echo '</ul>
          <hr>
          <div class="d-flex dropdown">
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
    $conexao->close();
?>

<div id="carouselPrincipal" class="carousel slide" data-bs-ride="carousel">

  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="2"></button>
    <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="3"></button>
    <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="4"></button>
    <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="5"></button>
  </div>
  
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="img/Arvore.jpeg" class="d-block w-100 img-fluid" style="height: 700px;">
        <div class="carousel-caption">
            <h2 style="color: black;">Book Tree</h2>
        </div>
    </div>
    <div class="carousel-item">
        <a href="terror.php">
            <img src="img/TerrorImagem.png" class="d-block w-100 img-fluid" style="height: 700px;">
        </a>
    </div>
    <div class="carousel-item">
        <a href="fantasia.php">
            <img src="img/FantasiaImagem.jpg" class="d-block w-100 img-fluid" style="height: 700px;">
        </a>
    </div>
    <div class="carousel-item">
        <a href="romance.php">
            <img src="img/RomanceImagem.jpg" class="d-block w-100 img-fluid" style="height: 700px;">
        </a>
    </div>
    <div class="carousel-item">
        <a href="ficcao.php">
            <img src="img/FiccaoImagem.jpg" class="d-block w-100 img-fluid" style="height: 700px;">
        </a>
    </div>
    <div class="carousel-item">
        <a href="drama.php">
            <img src="img/DramaImagem.jpg" class="d-block w-100 img-fluid" style="height: 700px;">
        </a>
    </div>
  </div>

  
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselPrincipal" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" style="background-color: black;"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselPrincipal" data-bs-slide="next">
    <span class="carousel-control-next-icon" style="background-color: black;"></span>
  </button>

</div>

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
                              <li><a href="#" target="_blank" id="linkfooter">Política Privacidade</a></li>
                              <li><a href="#" target="_blank" id="linkfooter">Termos Uso</a></li>
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