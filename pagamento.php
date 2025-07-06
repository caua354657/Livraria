<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Pagamento</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="imagex/png" href="img/Logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/pagamento.css">
</head>
<body>

<div class="pagamento-container">
        <form action="#" method="post">
              <div class="card bg-success text-white">
                <div class="card-body"><center><b>Pagamento</b></center></div>
              </div>
              <div class="mt-2 mb-3">
                <label for="pagamento" class="form-label">Forma de Pagamento</label>
                <select class="form-select" name="pagamento" required>
                  <option value="pix">🧾 BOLETO</option>
                  <option value="cartao">💳 CARTÃO</option>
                  <option value="boleto">💸PIX</option>
                </select>
              </div>
              <div class="d-flex">
                  <a href="carrinho.php" type="button" class="btn btn-secondary w-50 me-2">Voltar</a>
                  <a href="finalizar_compra.php" type="submit" class="btn btn-success w-50 me-2">Finalizar Compra</a>
              </div>
          </form>
</div>

</body>
</html>