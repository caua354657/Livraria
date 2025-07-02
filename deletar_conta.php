<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Excluir Conta</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/cssspinner/styles.css">
<link rel="stylesheet" href="css/deletar_conta.css">
</head>

<body>

<div class="container mt-3">

<?php
    if(isset($_GET['id_cliente']))
    {  
      include_once("conexaoSGBD.php");
      $id = $_GET['id_cliente'];
      $_SESSION['id_cliente'] = $id;

      $sql = "select * from cliente where id_cliente = $id";

      if($result = $conexao->query($sql))
      {
        $linha = $result->fetch_assoc();
        $id = $linha['id_cliente'];
        $nome = $linha['nome'];
        $_SESSION['id_cliente'] = $id;
        $_SESSION['nome'] = $nome;
      }
    }
?>

<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-danger text-white text-center fs-5 fw-semibold">🚨 Exclusão Conta</div>
        <div class="card-body text-center">
            <div class="d-flex justify-content-center gap-3">
                <p><strong>👤<?php echo $_SESSION['nome'];?></strong></p>
                <p><strong>🆔</strong> <?php echo $_SESSION['id_cliente'];?></p>
            </div>
            <p>Deseja realmente excluir? Isso resultará na perda de todos os dados</p>
        </div>
        <div class="card-footer">
            <div class="row g-2">
                <div class="col-6">
                    <a href="configuracoes.php" class="btn btn-secondary w-100">Cancelar</a>
                </div>
                <div class="col-6">
                    <a href="?id_cliente=<?php echo $_SESSION['id_cliente']; ?>&resp=sim" class="btn btn-danger w-100">Sim</a>
                </div>
            </div>
        </div>
        
<?php 
    if(isset($_SESSION['id_cliente']) and isset($_GET['resp']))   
    {
        $id = $_GET['id_cliente'];
        $_SESSION['id_cliente'] = $id;
        $sql = "select foto_perfil from cliente where id_cliente = $id";

        if($dados = $conexao->query($sql))
        {
            $linha = $dados->fetch_assoc();
            $foto = $linha['foto_perfil'];
            if(!empty($foto))
            {
                $arquivo = 'foto_perfil/'.$foto;
                if(file_exists($arquivo))
                    unlink($arquivo);
            }
        }

        $sqldeletar = "delete from cliente where id_cliente = ".$_SESSION['id_cliente'];

        if($conexao->query($sqldeletar))
        {
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                  </div>';
            session_unset(); //limpa as variáveis de sessão
            session_destroy(); // destrói a sessão
            header ("refresh: 2; url=index.php");
        }
        else
            echo "<div class='alert alert-danger'>
            <strong>Falha ao excluir cliente.</strong>.$conexao->error.
            </div>";
        $conexao->close(); 
    }
?>

    </div>
</div>

</div>

</body>
</html>