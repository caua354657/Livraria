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
  <link rel="stylesheet" href="css/add_pdf.css">
</head>
<body>
    
<?php
    include_once("conexaoSGBD.php");

    $id = $_GET['id'];
    $sql = "select * from livro where id_livro = $id";

    if($dados = $conexao->query($sql))
    {
        $linha = $dados->fetch_assoc();
        $titulo = $linha['titulo'];
    }
?>

<div class="container-pdf">
  
<form action="#" enctype="multipart/form-data" method="post">
    <div class="card bg-primary text-white">
        <div class="card-body"><center><b>Adicionar PDF Livro</b></center></div>
    </div>    
    <div class="mt-3 mb-3">
      <label for="titulo" class="form-label">📖 Título</label>
      <input type="text" class="form-control" name="titulo" disabled value="<?php echo $titulo; ?>">  
    </div>
    <div class="mt-3 mb-3">
      <label for="pdf" class="form-label">📄 PDF (Max: 2 MB)</label>
      <input type="file" class="form-control" name="pdf" required accept="application/pdf">  
    </div>
    <div class="row g-2">
        <div class="col-6">
            <div class="d-grid">
                <a href="gerenciar_livros.php" type="button" class="btn btn-secondary">Voltar</a>
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
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $uploaddir = "pdf_livro/";

        if(!is_dir($uploaddir))
            mkdir($uploaddir);

        $pdf = $_FILES['pdf']['name'];
        $uploadfile = $uploaddir . $_FILES['pdf']['name'];

        if(move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadfile))
        {
            $sql = "update livro set pdf = '$pdf' where id_livro = $id";

            if($conexao->query($sql))
            {
                header("refresh: 3; url=gerenciar_livros.php");
                echo '<div id="spinner-overlay">
                        <div id="spinner"></div>
                      </div>';
            }
            else
                echo "Houve um problema no upload do arquivo no SGBD.<br>".$conexao->error;
        }
        else
            echo "Houve um problema no upload do arquivo.<br>";
    }
    $conexao->close();
?>

</div>

</body>
</html>