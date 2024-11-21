<?php
require_once '../../config/bootstrap.php';
require_once '../../src/autoload.php';

$usuarioController = new UsuarioController();
$tipoUsuarioController = new TipoUsuarioController(); // Caso exista um controlador de tipos de usuários

// Verificar sessão de login
$sessoes = new Sessoes();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 1) {
    header('Location: ../index.php');
}

// Obtém o ID do usuário via GET
$usuarioId = $_GET['idusuario'] ?? null;
if (!$usuarioId) {
    header('Location: ?page=usuarios&pagina=1');
    exit;
}

// Busca os dados do usuário no banco de dados
$usuario = $usuarioController->obterUsuarioPorId(intval($usuarioId));
$tiposUsuarios = $tipoUsuarioController->listarTipo();

if (!$usuario) {
    header('Location: ?page=usuarios&pagina=1');
    exit;
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $tipo_usuario = intval($_POST['tipo_usuario'] ?? 0);

    // Atualiza o usuário
    if ($senha) {
        // Se a senha foi fornecida, criptografar a nova senha
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $usuarioController->atualizarUsuario($usuarioId, $nome, $email, $senha, $tipo_usuario);
    } else {
        // Se a senha não foi fornecida, mantém a senha atual
        $usuarioController->atualizarUsuario($usuarioId, $nome, $email, $usuario['senha_usuario'], $tipo_usuario);
    }

    // Redireciona após a atualização com uma mensagem de sucesso
    header("Location: ?page=usuarios&pagina=1&edit=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Usuário</title>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Editar Usuário</h1>
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Usuário</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email_usuario']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha (Deixe em branco para manter a atual)</label>
                <input type="password" class="form-control" id="senha" name="senha">
            </div>

            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuário</label>
                <select class="form-control" name="tipo_usuario" id="tipo_usuario">
                    <?php foreach ($tiposUsuarios as $tipo): ?>
                        <option value="<?= $tipo['id_tipo'] ?>" <?= $tipo['id_tipo'] == $usuario['id_tipo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo['descricao_tipo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="?page=usuarios&pagina=1" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
