<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Cadastro Cliente</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/cssspinner/styles.css">
<link rel="stylesheet" href="css/cadastro_cliente.css">
</head>
<body>

<div class="container-cliente">

<form action="#" class="was-validated" enctype="multipart/form-data" method="post">
    <div class="card bg-primary text-white">
        <div class="card-body"><center><b>Cadastro</b></center></div>
    </div>
    <div class="mb-2 mt-2">
      <label for="perfil" class="form-label">📷 Perfil</label>
      <input type="file" class="form-control" name="imagem" accept="image/*">
      <div class="valid-feedback">Não Obrigatório</div> 
    </div>
    <div class="row mb-2">
      <div class="col-6">
        <label for="nome" class="form-label">🙎 Nome</label>
        <input type="text" class="form-control" placeholder="Digite o nome" name="nome" required>
        <div class="valid-feedback">Válido</div>
        <div class="invalid-feedback">Preencha este campo.</div>
      </div>
      <div class="col-6">
        <label for="data" class="form-label">🗓️ Nascimento</label>
        <input type="date" class="form-control" name="data" required>
        <div class="valid-feedback">Válido</div>
        <div class="invalid-feedback">Preencha este campo.</div>
      </div>
    </div>
    <div class="row mb-2">
        <div class="col-6">
          <label for="email" class="form-label">📧 E-mail</label>
          <input type="email" class="form-control" placeholder="Seu email" name="email" required>
          <div class="valid-feedback">Válido</div>
          <div class="invalid-feedback">Preencha este campo.</div>
        </div>
        <div class="col-6">
          <label for="senha" class="form-label">🔒 Senha</label>
          <input type="password" maxlength="8" class="form-control" id="senha" placeholder="Sua senha" name="senha" required>
          <div class="valid-feedback">Válido</div>
          <div class="invalid-feedback">Preencha este campo.</div>
        </div>
    </div>
    <hr>
    <div class="d-grid">
        <div class="link-container d-flex">
            <h6>Possui uma conta?</h6>&nbsp;&nbsp;
            <a href="login.php">Faça Login</a>
        </div>
    </div>
    <div class="row g-2 mt-1">
        <div class="col-6">
            <div class="d-grid">
                <a href="index.php" type="button" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        <div class="col-6">
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Cadastrar</button>
            </div>
        </div>    
    </div>
</form>

<?php 
// cadastro
if($_POST)
    {
      include_once("conexaoSGBD.php");
      $uploaddir = 'foto_perfil/';

      if(!is_dir($uploaddir))
        mkdir($uploaddir);

      $imagem = $_FILES['imagem']['name'];
      $uploadfile = $uploaddir . $_FILES['imagem']['name'];
      
      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $senha = md5($_POST['senha']);
      $data = $_POST['data'];
      
      if(!empty($_FILES['imagem']['name']))
      {
        if(move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile))
        {
          $sql = "insert into cliente(foto_perfil, nome, email, senha, data) values('$imagem','$nome','$email','$senha','$data')";

          if($conexao->query($sql))
          {
            header("refresh: 3; url=index.php");
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                  </div>';
          }
        }
        else
          echo '<div class="alert alert-danger">
                  <strong>Falha ao Cadastrar.</strong>'.$conexao->error.'
                </div>';
      }
      else
        {
           $sql = "insert into cliente(nome, email, senha, data) values('$nome','$email','$senha','$data')";
    
            if($conexao->query($sql))
            {
              header ("refresh: 3; url=index.php");
              echo '<div id="spinner-overlay">
                        <div id="spinner"></div>
                    </div>';
            }
        } 
          $conexao->close();
    }
?>

</div>
    
</body>
</html>