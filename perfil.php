<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Perfil</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/perfil.css">
</head>
<body>

<?php
    //para mostrar os dados
      include_once("conexaoSGBD.php");
      $id = $_SESSION['id_cliente'];
      $sql = "select * from cliente where id_cliente = $id";

      if($result = $conexao->query($sql))
      {
        $linha = $result->fetch_assoc();
        $foto = $linha['foto_perfil'];
        $data = date("d/m/Y", strtotime($linha['data']));
        $email = $linha['email'];
        $senha = $linha['senha'];
      } 
?>

<div class="container my-5 p-0" id="container">
    <div class="header-card">👤 Dados do Perfil</div>
    <div class="container-imagem mt-3">
        <img src="foto_perfil/<?php echo $foto; ?>" class="profile-img" width="80" height="80" alt="Foto do usuário">
    </div>
    <div class="info-section">
        <div class="info-item">🆔 <strong>Conta:</strong> <?php echo $_SESSION['id_cliente']; ?></div>
        <div class="info-item">🙎 <strong>Usuário:</strong> <?php echo $_SESSION['nome']; ?></div>
        <div class="info-item">🗓️ <strong>Nascimento:</strong> <?php echo $data; ?></div>
        <div class="info-item">📧 <strong>Email:</strong> <?php echo $email; ?></div>
    </div>
    <div class="btn-group d-flex justify-content-between gap-2 p-3">
        <a href="configuracoes.php" class="btn btn-secondary w-50">Voltar</a>
        <a href="alterar_perfil.php" class="btn btn-success w-50">Editar Perfil</a>
    </div>
</div>

</body>
</html>