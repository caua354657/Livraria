<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/cssspinner/stylesum.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="login-container">
      <main>
        <form action="#" method="post">
          <div class="card bg-primary text-white">
              <div class="card-body"><b>Login</b></div>
          </div>
          <div class="mb-2 mt-2">
            <label class="form-label">📧 E-mail</label>
            <input type="email" class="form-control" required placeholder="Digite o e-mail" name="email">
          </div>
          <div class="mb-2 mt-2 senha-container">
            <label class="form-label">🔒 Senha</label>
            <input type="password" class="form-control" required placeholder="Digite a senha" name="senha" id="senha">
            <span class="olho" onclick="mostrarOcultarSenha(this)">🙈</span>
          </div>
          <div class="d-flex mb-3">
            <a href="cadastro_cliente.php">Cadastre-se</a>
            <a href="esqueceu_senha.php" class="ms-auto">Esqueceu Senha?</a>
          </div>
          <div class="d-flex">
            <a href="index.php" type="button" class="btn btn-secondary w-50 me-2">Voltar</a>
            <button class="w-50 btn btn-success" type="submit">Login</button>
          </div>
        </form>
      </main>

<?php 
    if($_POST)
    {
    include_once("conexaoSGBD.php");
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); 

    $sql = "select * from cliente where email='$email' and senha='$senha'";

    if($result = $conexao->query($sql))
    {
        if($result->num_rows > 0)
        {
           $linha = $result->fetch_assoc();
           $id = $linha['id_cliente'];
           $nome = $linha['nome'];
           $admin = $linha['funcao'];
           $_SESSION['id_cliente'] = $id; // para a foto perfil
           $_SESSION['nome'] = $nome; // para o botao conta
           $_SESSION['adm'] = $admin; // se for adm ou nao
           echo '<div id="overlay">
                    <div class="spinner-grow" style="color: green;" role="status"></div>
                    <div class="spinner-grow" style="color: green;" role="status"></div>
                    <div class="spinner-grow" style="color: green;" role="status"></div>
                 </div>';
           header ("refresh: 2; url=index.php");
           
        }
        else
            echo '<script>alert("Usuário/Senha Incorreto. Tente Novamente!")</script>';
    }
    else 
        echo 'Erro ao executar a consulta. '.$conexao->error;
        $conexao->close();
    }
?>

<script src="js/login.js"></script>

</div>

</body>
</html>