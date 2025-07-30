<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Vizualização Sugestão</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/ver_sugestoes.css">
</head>
<body>

<div class="container mt-3">

<?php
   $id = $_GET['id'];
      include_once("conexaoSGBD.php");
      $sql = "select * from notificacoes where id_notificacao = $id";

      if($result = $conexao->query($sql))
      {
        $totalRegistros = $result->num_rows;
    
        if($totalRegistros > 0)
        {
            $linha = $result->fetch_assoc();
            $sugestao = $linha['mensagem'];
            $fk_cliente = $linha['id_cliente'];

            if(file_exists($sugestao))
                $conteudo = file_get_contents($sugestao); // faz a leitura do arquivo - mostra a escrita
            else
                echo "<div class='alert alert-danger'>Arquivo não encontrado.</div>";
        }
        else 
            echo "<div class='alert alert-warning'>Sugestão não encontrada.</div>";
      }
      else
        echo "<div class='alert alert-warning'>ID inválido.</div>";

    $conexao->close();
?>

<div class="container">
    <div class="card">
        <div class="header">🔔 Notificação: <?php echo $id;?></div>
        <div class="card-body text-start">
            <b>Cliente:</b> <?php echo $fk_cliente;?>
            <br>
            <b>Sugestão:</b> <?php echo $conteudo;?>
        </div>
        <div class="card-body text-center">
            <div class="d-grid">
                <a href="notificacoes.php" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</div>

</div>

</body>
</html>