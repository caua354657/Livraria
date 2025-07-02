<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Dados Cliente</title>    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/cssspinner/styles.css">
<link rel="stylesheet" href="css/alterar_perfil.css">
</head>

<body>

<?php
    if(isset($_SESSION['nome']))
    {
    //para mostrar os dados
      include_once("conexaoSGBD.php");
      $id = $_SESSION['id_cliente'];

      $sql = "select * from cliente where id_cliente = $id";

      if($result = $conexao->query($sql))
      {
        $linha = $result->fetch_assoc();
        $id = $linha['id_cliente'];
        $foto = $linha['foto_perfil'];
        $nome = $linha['nome'];
        $email = $linha['email'];
        $data = $linha['data'];
      }
    }
?>

<div class="d-flex justify-content-center align-items-center min-vh-100">
   <div class="container-alterar">

    <div class="header-card bg-primary text-white d-flex justify-content-center align-items-center" style="height: 60px; border-radius: 5px;">
        <h4 class="m-0">Alterar Perfil</h4>
    </div>

    <form action="#" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-2 mt-2">
            <label for="perfil" class="form-label">📷 Perfil</label>
            <div class="d-flex align-items-center">
                <img src="foto_perfil/<?php echo $foto; ?>" id="preview" class="rounded-4 shadow border border-dark" style="width: 90px; height: 90px; border-radius: 8px;">
                <input type="file" id="inputimagem" class="form-control" name="imagem" accept="image/*" style="margin-left: 20px;">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <label for="nome">🙎 Nome</label>
                <input type="text" class="form-control" placeholder="Digite o nome" name="nome" value="<?php echo $nome; ?>">
            </div>
            <div class="col-6">
                <label for="nascimento">🗓️ Nascimento</label>
                <input type="date" class="form-control" placeholder="Digite o autor" name="data" value="<?php echo $data; ?>">
            </div>
        </div>
        <div class="mb-2">
            <label for="email">📧 E-mail</label>
            <input type="email" class="form-control" placeholder="Digite o email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="mb-3">
            <label for="senha">🔒 Senha</label>
            <input type="password" class="form-control" required placeholder="Confirme senha cliente para alterar" name="senha">
        </div>
        <div class="row g-2">
            <div class="col-6">
                <div class="d-grid">
                    <a href="configuracoes.php" type="button" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
            <div class="col-6">
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Alterar</button>
                </div>
            </div>    
        </div>
    </form>

<?php
    //para alterar os dados
    if($_POST) 
    {
        $uploaddir = 'foto_perfil/';

        if(!is_dir($uploaddir))
            mkdir($uploaddir);

        $imagem = $_FILES['imagem']['name'];
        $uploadfile = $uploaddir . $_FILES['imagem']['name'];
        
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = md5($_POST['senha']);
        $data = $_POST['data'];
        
        $sql = "select * from cliente where senha = '$senha' and id_cliente = $id";
        $resultado = $conexao->query($sql);

        if($resultado->num_rows >0)
        {    
           if(!empty($_FILES['imagem']['name']))
            {
                if(move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile))
                {
                    $sqlup = "update cliente set foto_perfil = '$imagem', nome = '$nome', data = '$data', email = '$email' where id_cliente = $id";
    
                        if($conexao->query($sqlup))
                        {
                            header ("refresh: 1; url=index.php");
                            echo '<div id="spinner-overlay">
                                    <div id="spinner"></div>
                                  </div>';
                        }
                        else
                            echo '<div class="alert alert-danger text-center">
                                    <strong>Erro ao atualizar dados.</strong>
                                 </div>';
                }
                else
                    echo '<div class="alert alert-danger">
                            <strong>Falha no Upload.</strong>'.$conexao->error.'
                         </div>';
            }
            else
            {
                $sqlup = "update cliente set nome = '$nome', data = '$data', email = '$email' where id_cliente = $id";
    
                if($conexao->query($sqlup))
                {
                    header ("refresh: 1; url=index.php");
                    echo '<div id="spinner-overlay">
                            <div id="spinner"></div>
                          </div>';
                    ob_end_flush();
                }
                else
                    echo '<div class="alert alert-danger text-center">
                            <strong>Erro ao atualizar dados.</strong>
                         </div>';
            } 
        }
        else
            echo '<div id="alerta" class="alerta">
                    <div class="alerta-conteudo">
                        <p>🔒 Senha incorreta</p>
                    </div>
                  </div>';
    }
    $conexao->close();
?>

<script src="js/alterar_perfil.js"></script>

</div>

</body>
</html> 