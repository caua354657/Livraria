<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/gerenciar_livros.css">
<title>Livros Cadastrados</title>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="header-titulo d-flex justify-content-center align-items-center" style="height: 80px;">
            <h4 class="m-0">📚 Gerenciamento Livros</h4>
        </div>
        <div class="card-body">
         <div class="d-flex">
            <div class="text-start mt-1">
                <a href="index.php" class="btn btn-secondary">Voltar</a>
            </div>
            <form action="#" method="POST" class="search-form ms-auto mt-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Pesquisar..." name="a">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
         </div>

<?php
    include_once("conexaoSGBD.php");
    
    if(isset($_GET['id_livro']))
    {
        $id = $_GET['id_livro'];
        $sql = "select imagem from livro where id_livro = $id";

        if($result = $conexao->query($sql))
        {
            $row = $result->fetch_assoc();
            $capa = $row['imagem'];
            if(!empty($capa)) 
            {
              $arquivo = 'capa_livro/' . $capa;
              if(is_file($arquivo))
                 unlink($arquivo);
            }
        }
        
        $sqldeletar = "delete from livro where id_livro = $id";

        if($conexao->query($sqldeletar))
        {
            echo '';
        }
        else
            echo '<div class="alert alert-danger">
                    <strong>Falha ao excluir Livro.</strong>'.$conexao->error.'
                  </div>';
    }
?>

<?php
    if ($_POST)
        $a = $_POST['a'];
    else
        $a = '';

    $sql = "select id_livro, titulo, autor, preco, imagem, fk_categoria from livro where titulo like '%$a%' order by id_livro";

    if ($dados = $conexao->query($sql)) 
    {
        $totalRegistros = $dados->num_rows;
        echo '<br>';
        echo '<h6><b>📚 Total:</b> '.$totalRegistros.'</h6>';
        echo '<br>';

        if ($totalRegistros > 0) 
        {
            echo '<div style="overflow-x: auto;">';
            echo '<table class="table table-striped table-bordered table-hover" id="myTable">';
            echo '<thead class="table-dark text-center">';
            echo '<tr>';
            echo '<th> ID </th>';
            echo '<th> Capa </th>';
            echo '<th> Título </th>';
            echo '<th> Autor </th>';
            echo '<th> Preço </th>';
            echo '<th> Categoria </th>';
            echo '<th> Ações </th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody class="text-center">';

            while ($linha = $dados->fetch_assoc()) 
            {
                $id = $linha['id_livro'];
                echo '<tr>';
                echo '<td>'.$linha['id_livro'].'</td>';
                echo '<td><img src="capa_livro/'.$linha['imagem'].'" width="50" height="50"></td>';
                echo '<td>'.$linha['titulo'].'</td>';
                echo '<td>'.$linha['autor'].'</td>';
                echo '<td>R$'.number_format($linha['preco'], 2, ',', '.').'</td>';
                echo '<td>'.$linha['fk_categoria'].'</td>';
                echo '<td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="cadastro_livros.php">
                                <button type="button" class="btn btn-outline-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="black" viewBox="0 0 24 24">
                                        <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/>
                                    </svg>
                                </button>
                            </a>
                            <a href="alterar_livro.php?id='.$linha['id_livro'].'"><button type="button" class="btn btn-outline-success w-100">✏️</button></a>
                            <a href="?id_livro='.$id.'"><button type="button" class="btn btn-outline-danger w-100" onclick="alert(\'Livro '.$id.' excluído com sucesso\')">❌</button></a>
                        </div>
                     </td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
        
        else 
            echo '<center><a href="cadastro_livros.php"><button type="button" class="btn btn-outline-primary">Cadastrar Livro</button></a></center>';
        
    } 
        else 
            echo 'Erro: '.$conexao->error;
        $conexao->close();
?>

        </div>
    </div>
</div>

</body>
</html>
