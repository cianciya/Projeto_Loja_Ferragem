<?php

require_once '../src/autoload.php';
require_once '../config/Sessoes.php';

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
        header('Location: ../public_html/index.php'); // Redirecionar em caso de sucesso
    } else {
        echo 'Login falhou. Verifique suas credenciais.';
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../public_html/assets/imagens/qual-kit-de-ferramentas-mais-completo.jpg');
            object-fit: contain;
            background-repeat: no-repeat;
            background-size: cover
        }

        .login-container {
            margin-top: 100px;

        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small><a href="#">Esqueceu a senha?</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>