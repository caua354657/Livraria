<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Sugestões</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
  <link rel="stylesheet" href="css/sugestoes.css">
  <link rel="stylesheet" href="css/cssspinner/styles.css">
</head>
<body>

<?php
    include_once('conexaoSGBD.php');
    $id = $_SESSION['id_cliente'];
    $sql = "select * from cliente where id_cliente = '$id'";

    if($result = $conexao->query($sql))
    {
        if($linha = $result->fetch_assoc())
        {
            $id = $linha['id_cliente'];
            $nome = $linha['nome'];
        }
    }
?>

<div class="container mt-3">
  
<form action="#" enctype="multipart/form-data" method="post">
    <div class="card bg-primary text-white">
        <div class="card-body"><center><b>Sugestões Site</b></center></div>
    </div>    <div class="mt-3 mb-2">
      <label for="nome" class="form-label">🙎 Usuário</label>
      <input type="text" class="form-control" name="nome" disabled value="<?php echo $nome; ?>">  
    </div>
    <div class="mt-3 mb-2">
        <label for="sugestao" class="form-label">💬 Enviar sugestão</label>
        <textarea class="form-control" name="texto" rows="3" placeholder="Digite sua sugestão aqui..." required></textarea>
    </div>
    <hr>
        <div class="row">
            <div class="col-6">
                <div class="d-grid">
                    <a href="index.php" type="button" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
            <div class="col-6">
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>
            </div>    
        </div>
</form>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') // Verifica se o formulário foi enviado pelo método POST
{   
    $pasta = 'sugestoes/';
    
    if(!is_dir($pasta)) 
       mkdir($pasta);

    $arquivo = $pasta. "mensagem_". time().".txt"; // Cria um nome de arquivo único usando a hora atual (timestamp) - salva no banco dados
    $mensagem = $_POST['texto'];
    file_put_contents($arquivo, $mensagem); // Cria ou sobrescreve o arquivo com o conteúdo da variável $mensagem
    $fk_cliente = $id;
  
    $sql = "insert into notificacoes(mensagem, id_cliente) values('$arquivo','$fk_cliente')";

        if($conexao->query($sql))
        {
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                 </div>';
            header("refresh: 3; url=index.php");
        }
        else
            echo '<div class="alert alert-warning" role="alert">
                    <strong>Atenção!</strong> Erro ao enviar sugestão'.$conexao->error.'
                  </div>';
}
        $conexao->close();
?>

</div>

</body>
</html>