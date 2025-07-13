<?php
ob_start();
?>

<DOCTYPE html>
<html lang="pt-br">
<head>
<title>Dados Livro</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/cssspinner/styles.css">
<link rel="stylesheet" href="css/alterar_livro.css">
</head>

<body>

<?php
      //para mostrar os dados
      include_once("conexaoSGBD.php");
      $id = $_GET['id'];
      $sql = "select * from livro where id_livro = $id";

      if($result = $conexao->query($sql))
      {
        $linha = $result->fetch_assoc();
        $id = $linha['id_livro'];
        $capa = $linha['imagem'];
        $titulo = $linha['titulo'];
        $autor = $linha['autor'];
        $preco = $linha['preco'];
        $categoria = $linha['id_categoria'];
      }
?>

<div class="d-flex justify-content-center align-items-center min-vh-100">
   <div class="container-alterar">

    <div class="card bg-primary text-white">
        <div class="card-body"><center><b>Alterar Livro</b></center></div>
    </div>
  
    <form action="#" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-2 mt-2">
            <label for="perfil" class="form-label">📷 Capa Livro</label>
            <div class="d-flex align-items-center">
                <img src="capa_livro/<?php echo $capa; ?>" id="preview" class="rounded-4 shadow border border-dark" style="width: 90px; height: 90px; border-radius: 8px;">
                <input type="file" id="inputimagem" class="form-control" name="imagem" accept="image/*" style="margin-left: 20px;">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <label for="titulo">📖 Título</label>
                <input type="text" class="form-control" placeholder="Digite o nome do livro" name="titulo" value="<?php echo $titulo; ?>">
            </div>
            <div class="col-6">
                <label for="autor">✍️ Autor</label>
                <input type="text" class="form-control" placeholder="Digite o autor" name="autor"value="<?php echo $autor; ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <label for="autor">💲 Preço</label>
                <input type="text" class="form-control" name="preco" placeholder="Digite o preço" 
                onkeypress="return (event.charCode >= 48 && event.charCode <= 57)  || event.charCode == 13 || event.charCode == 44" required value="<?php echo $preco; ?>">
            </div>
            <div class="col-6">
                <label for="categoria">🏷️ Categoria</label>
                <select class="form-select form-control" name="id_categoria">
                    <option value="" disabled selected style="background-color: black; color: white;">Selecione uma categoria</option>
                    <option value="1" <?php if ($categoria == 1) echo 'selected'; ?>>Terror</option>
                    <option value="2" <?php if ($categoria == 2) echo 'selected'; ?>>Fantasia</option>
                    <option value="3" <?php if ($categoria == 3) echo 'selected'; ?>>Romance</option>
                    <option value="4" <?php if ($categoria == 4) echo 'selected'; ?>>Ficção</option>
                    <option value="5" <?php if ($categoria == 5) echo 'selected'; ?>>Drama</option>
                </select>
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
                    <button type="submit" class="btn btn-success">Alterar</button>
                </div>
            </div>    
        </div>
    </form>

<?php 
    //para alterar os dados
    if($_POST) 
    {
        $uploaddir = 'capa_livro/';

        if(!is_dir($uploaddir))
            mkdir($uploaddir);

        $imagem = $_FILES['imagem']['name'];
        $uploadfile = $uploaddir . $_FILES['imagem']['name'];

        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $preco = $_POST['preco'];
        $categoria = $_POST['id_categoria'];
        
        if(!empty($_FILES['imagem']['name']))
        {
            if(move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile))
            {
                $sql = "update livro set imagem = '$imagem', titulo = '$titulo', autor = '$autor', preco = '$preco', id_categoria = '$categoria' where id_livro = $id";
 
                if($conexao->query($sql))
                {
                    header ("refresh: 1; url=gerenciar_livros.php");
                    echo '<div id="spinner-overlay">
                            <div id="spinner"></div>
                        </div>';
                    ob_end_flush();
                }
            }
            else
                echo "<div class='alert alert-danger'>
                        <strong>Falha ao alterar Livro.</strong>'.$conexao->error.'
                      </div>";
        }
        else
        {   
            $sql = "update livro set titulo = '$titulo', autor = '$autor', preco = '$preco', id_categoria = '$categoria' where id_livro = $id";
 
            if($conexao->query($sql))
            {
                header ("refresh: 1; url=gerenciar_livros.php");
                echo '<div id="spinner-overlay">
                        <div id="spinner"></div>
                     </div>';
            }
        } 
    }
    $conexao->close();
?>

<script src="js/alterar_livro.js"></script>

   </div>
</div>

</body>
</html>