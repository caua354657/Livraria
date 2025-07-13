<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Adicionar Categoria</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/cssspinner/styles.css">
  <link rel="stylesheet" href="css/add_categoria.css">
</head>
<body>
    
<div class="container-categoria">
  
<form action="#" method="post">

    <div class="card bg-primary text-white">
        <div class="card-body"><center><b>Cadastrar Categoria</b></center></div>
    </div>    
    <div class="mt-3 mb-3">
      <label for="nome" class="form-label">🏷️ Categoria</label>
      <input type="text" class="form-control" required placeholder="Digite a Categoria" name="categoria">  
    </div>
    <div class="mt-3 mb-3">
      <label for="nome" class="form-label">🔗 Página Destino</label>
      <input type="text" class="form-control" required placeholder="Digite o destino" name="destino">  
    </div>
    <div class="row g-2">
        <div class="col-6">
            <div class="d-grid">
                <a href="gerenciar_categorias.php" type="button" class="btn btn-secondary">Voltar</a>
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
    include_once("conexaoSGBD.php");

    if($_POST)
    {
        $categoria = $_POST['categoria'];
        $pagina = $_POST['destino'];

        $sqlinsert = "insert into categoria(descricao, destino) values('$categoria', '$pagina')";

        if($conexao->query($sqlinsert))
        {
            header("refresh: 1; url=gerenciar_categorias.php");
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                  </div>';
        }
        else
            echo '<div class="alert alert-danger">
                    <strong>Falha ao Cadastrar</strong>'.$conexao->error.'
                  </div>';
    }
    $conexao->close();
?>

</div>

</body>
</html>