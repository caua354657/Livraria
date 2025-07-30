<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Notificações</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/notificacoes.css">
</head>
<body>

<div class="container">
    <div class="card">
        <div class="header-titulo d-flex justify-content-center align-items-center" style="height: 80px;">
            <h4 class="m-0">🔔 Notificacões</h4>
        </div>
        <div class="card-body">
            <div class="text-start mt-1 mb-4">
                <a href="index.php" class="btn btn-secondary">Voltar</a>
            </div>


<?php
    include_once('conexaoSGBD.php');
    
    if(isset($_GET['id'])) 
    {   
        $id = $_GET['id'];
        $sql = "select mensagem from notificacoes where id_notificacao = $id";
        
        if($result = $conexao->query($sql))
        {
            if($row = $result->fetch_assoc())
            {
                $arquivo = $row['mensagem'];
                if(!empty($arquivo)) // verifica se nao está vazio o arquivo
                    if(file_exists($arquivo)) // se existe o arquivo
                        unlink($arquivo); //apaga arquivo
            }

            $sqldeletar = "delete from notificacoes where id_notificacao = $id";
            
            if($conexao->query($sqldeletar))
                echo '';
            else
                echo '<div class="alert alert-danger">
                        <strong>Falha ao excluir Notificação.</strong>'.$conexao->error.'
                      </div>';
        }
        else 
            echo '<div class="alert alert-danger">
                    <strong>Erro ao buscar notificação.</strong>'.$conexao->error.'
                  </div>';
    }
?>

<?php
    $sql = "select * from notificacoes order by id_notificacao desc limit 30";

    if ($dados = $conexao->query($sql)) 
    {
        $totalRegistros = $dados->num_rows;

        if ($totalRegistros > 0) 
        {
            while($linha = $dados->fetch_assoc()) 
            {
                echo '<div style="display: flex; align-items: center;">
                         <div class="alert alert-success w-100" id="alertasucesso" style="display: flex; flex-direction: column;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <h5>🙎🏽‍♂️ Cliente: '.$linha['id_cliente'].'&nbsp;&nbsp;&nbsp;<a href="ver_sugestoes.php?id='.$linha['id_notificacao'].'"><button class="btn btn-dark">Ver Sugestão</button></a></h5>
                                <a href="?id='.$linha['id_notificacao'].'"><h3><i class="fas fa-trash-alt text-danger" style="margin-left: auto;"></i></h3></a>
                            </div>
                         </div>
                      </div>';
            }
        }
        else 
            echo '<div class="alert alert-warning" role="alert">
                    <strong>Atenção!</strong> Não há notificações.
                  </div>';
        
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
