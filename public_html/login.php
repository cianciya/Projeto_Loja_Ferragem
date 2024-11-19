<?php

require_once '../src/autoload.php';
require_once '../config/Sessoes.php';
require_once '../config/bootstrap.php';

$sessoes = new Sessoes();
if (isset($_SESSION['tipo'])) {
    switch ($_SESSION['tipo']) {
        case 1: // tipo adm
            header('Location: ../public_html/admin/index.php');
            break;
        case 2: // tipo gerente
            header('Location: ../public_html/gerente/index.php');
            break;
        case 3: // tipo cliente
            header('Location: ../public_html/index.php');
            break;
        case 4: // tipo funcionário
            header('Location: ../public_html/funcionario/index.php');
            break;
    }
}

$toastHtml = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];



    // Criar instância do controller
    $usuarioController = new UsuarioController();

    // Chamar o método de login
    $resultado = $usuarioController->login($email, $senha);

    if ($resultado) {
        $sessoes->setSession('email', $resultado['email_usuario']);
        $sessoes->setSession('tipo', $resultado['id_tipo']);
        echo '<div class="alert alert-success" role="alert">Login bem-sucedido!</div>';
        switch ($_SESSION['tipo']) {
            case 1: // tipo adm
                header('Location: ../public_html/admin/index.php');
                break;
            case 2: // tipo gerente
                header('Location: ../public_html/gerente/index.php');
                break;
            case 3: // tipo cliente
                header('Location: ../public_html/index.php');
                break;
            case 4: // tipo funcionário
                header('Location: ../public_html/funcionario/index.php');
                break;
        }
    } else {
        $toastHtml = '<div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
              <div class="d-flex">
                <div class="toast-body">
                  Senha incorreta. Tente novamente!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
            </div>
          </div>';
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-image: url('../public_html/assets/imagens/qual-kit-de-ferramentas-mais-completo.jpg');
            object-fit: contain;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

    </style>
</head>

<body>
<div class="container login-container">
    <div class="d-flex row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small><a href="#">Esqueceu a senha?</a></small>
                </div>
            </div>
        </div>
    </div>
</div>


    <?=  $toastHtml ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
</body>

</html>