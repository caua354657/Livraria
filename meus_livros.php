<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meus Livros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">

<?php
    include_once("conexaoSGBD.php");
    $id = $_SESSION['id_cliente'];
                                                                                                                                  // mostra total de livro por id
    $sql = "select livro.id_livro, livro.titulo, livro.autor, livro.preco, livro.imagem, livro.pdf, sum(vendas_produto.quantidade) as total_quantidade
            from vendas_produto join vendas on vendas_produto.id_venda = vendas.id_venda join livro on vendas_produto.id_livro = livro.id_livro
            where vendas.id_cliente = $id group by livro.id_livro, livro.titulo, livro.autor, livro.preco, livro.imagem, livro.pdf order by livro.id_livro";

    if ($result = $conexao->query($sql)) 
    {
        if($result->num_rows > 0) 
        {
            echo '<div class="card bg-primary text-white">
                    <div class="card-body"><center><h4><b>📖 Meus Livros</b></h4></center></div>
                  </div>';
            echo '<a href="index.php" class="btn btn-secondary mt-3">Voltar</a>';

            echo '<div class="container livros-container my-5">';
            echo '<div class="row g-5">';

            while ($row = $result->fetch_assoc()) 
            {
                $qtd = $row['total_quantidade'];
                $arquivo = $row['pdf'];

                echo '<div class="col-6 col-md-4 d-flex justify-content-center">
                        <div class="card" style="width: 280px;">
                            <img src="capa_livro/'.$row['imagem'].'" class="card-img-top" style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">'.$row['titulo'].'</h5>
                                <p class="card-text mb-1 text-muted fst-italic">'.$row['autor'].'</p>
                                <p class="card-text fw-bold">Possuí: '.$qtd.'</p>
                                <p class="card-text fw-bold" style="color: rgb(159, 133, 28)">R$' . number_format($row['preco'], 2, ',', '.') . '</p>
                                <a href="pdf_livro/'.$arquivo.'" class="btn btn-outline-primary w-100" download>PDF</a>
                            </div>
                        </div>
                    </div>';
            }

            echo '</div>';
            echo '</div>';
        } 
        else 
        {
            echo '<div class="alert alert-danger text-center" role="alert">
                    <h4><b>📖 Você não comprou nenhum livro</b></h4>
                    <h6>Aguarde redirecionar...</h6>
                  </div>';
            header("refresh: 2; url=index.php");
        }
    } 
    else
        echo '<div class="alert alert-danger">'.$conexao->error.'</div>';
        $conexao->close();
?>

</div>

</body>
</html>
