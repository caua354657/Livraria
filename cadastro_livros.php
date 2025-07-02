<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Cadastro Livro</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/cssspinner/styles.css">
<link rel="stylesheet" href="css/cadastro_livros.css">
</head>
<body>

<div class="container-livro">

    <form action="#" class="was-validated" enctype="multipart/form-data" method="POST">
        <div class="card bg-primary text-white">
            <div class="card-body"><center><b>Cadastrar Livro</b></center></div>
        </div>
        <div class="mb-2 mt-2">
            <label for="perfil" class="form-label">📷 Capa Livro</label>
            <input type="file" class="form-control" name="imagem" required accept="image/*">
            <div class="valid-feedback">Válido</div>
            <div class="invalid-feedback">Preencha este campo.</div>
        </div>
        <div class="mb-2 mt-2">
            <label for="perfil" class="form-label">📄 PDF Livro</label>
            <input type="file" class="form-control" name="pdf" required accept="application/pdf">
            <div class="valid-feedback">Válido</div>
            <div class="invalid-feedback">Preencha este campo.</div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <label for="titulo">📖 Título</label>
                <input type="text" class="form-control" required placeholder="Digite o nome do livro" name="titulo">
                <div class="valid-feedback">Válido</div>
                <div class="invalid-feedback">Preencha este campo.</div>
            </div>
            <div class="col-6">
                <label for="autor">✍️ Autor</label>
                <input type="text" class="form-control" required placeholder="Digite o autor" name="autor">
                <div class="valid-feedback">Válido</div>
                <div class="invalid-feedback">Preencha este campo.</div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <label for="autor">💲 Preço</label>
                <input type="text" class="form-control" required name="preco" placeholder="Digite o preço" 
                onkeypress="return (event.charCode >= 48 && event.charCode <= 57)  || event.charCode == 13 || event.charCode == 44" required>
                <div class="valid-feedback">Válido</div>
                <div class="invalid-feedback">Preencha este campo.</div>
            </div>
            <div class="col-6">
                <label for="categoria">🏷️ Categoria</label>
                <select class="form-select form-control" required name="fk_categoria">
                    <option value="" disabled selected style="background-color: black; color: white;">Selecione uma categoria</option>
                    <option value="1">Terror</option>
                    <option value="2">Fantasia</option>
                    <option value="3">Romance</option>
                    <option value="4">Ficção</option>
                    <option value="5">Drama</option>
                </select>
                <div class="valid-feedback">Válido</div>
                <div class="invalid-feedback">Preencha este campo.</div>
            </div>
        </div>
        <div class="row g-2 mt-2">
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
  include_once("conexaoSGBD.php");

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $uploaddir = 'capa_livro/';
    $pdf = 'pdf_livro/';

    if(!is_dir($uploaddir))
      mkdir($uploaddir);
    if(!is_dir($pdf))
      mkdir($pdf);

    $imagem = $_FILES['imagem']['name'];
    $uploadfile = $uploaddir . $_FILES['imagem']['name'];
    $arquivo_pdf = $_FILES['pdf']['name'];
    $pdf_livro = $pdf . $_FILES['pdf']['name'];

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $preco = str_replace(",",".", $_POST['preco']);
    $categoria = $_POST['fk_categoria'];

    //está caindo na linha 127 // move_uploaded_file permite apenas mover um arquivo
    if(move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile) and move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_livro))
    {
      $sql = "insert into livro(imagem, titulo, autor, pdf, preco, fk_categoria) values('$imagem','$titulo','$autor','$arquivo_pdf','$preco','$categoria')";

      if($conexao->query($sql))
      {
        header ("refresh: 3; url=gerenciar_livros.php");
        echo '<div id="spinner-overlay">
                <div id="spinner"></div>
              </div>';
        ob_end_flush();
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