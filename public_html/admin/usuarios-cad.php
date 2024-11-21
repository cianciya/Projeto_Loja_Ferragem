<?php
require_once '../../config/bootstrap.php';
require_once '../../src/autoload.php';

// Instanciando o controlador
$usuarioController = new UsuarioController();
$tiposController = new TipoUsuarioController(); // Caso exista um controlador de tipos de usuários

// Variáveis de erro
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $nome_usuario = $_POST['nome_usuario'] ?? '';
    $email_usuario = $_POST['email_usuario'] ?? '';
    $senha_usuario = $_POST['senha_usuario'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'] ?? '';

    // Validação simples
    if (empty($nome_usuario) || empty($email_usuario) || empty($senha_usuario) || empty($tipo_usuario)) {
        $erro = 'Todos os campos são obrigatórios!';
    } elseif (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido!';
    } else {
        // Chamar o controlador para adicionar o usuário
        try {
            // Encriptar a senha antes de salvar
            $senha_usuario = password_hash($senha_usuario, PASSWORD_DEFAULT);
            $usuarioController->adicionarUsuario($nome_usuario, $email_usuario, $senha_usuario, $tipo_usuario);
            $sucesso = 'Usuário cadastrado com sucesso!';
        } catch (Exception $e) {
            $erro = 'Erro ao cadastrar o usuário: ' . $e->getMessage();
        }
    }
}

// Carregar os tipos de usuários (se houver) para os campos do formulário
$tipos_usuarios = $tiposController->listarTipo(); // Método para listar os tipos de usuário

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Usuário</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Cadastrar Novo Usuário</h1>

    <!-- Exibir mensagens de erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= $erro; ?></div>
    <?php endif; ?>
    <?php if ($sucesso): ?>
        <div class="alert alert-success"><?= $sucesso; ?></div>
    <?php endif; ?>

    <!-- Formulário de Cadastro de Usuário -->
    <form action="#" method="POST">
        <div class="mb-3">
            <label for="nome_usuario" class="form-label">Nome do Usuário:</label>
            <input 
                type="text" 
                id="nome_usuario" 
                name="nome_usuario" 
                class="form-control" 
                required 
                value="<?= $nome_usuario ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label for="email_usuario" class="form-label">E-mail do Usuário:</label>
            <input 
                type="email" 
                id="email_usuario" 
                name="email_usuario" 
                class="form-control" 
                required 
                value="<?= $email_usuario ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label for="senha_usuario" class="form-label">Senha:</label>
            <input 
                type="password" 
                id="senha_usuario" 
                name="senha_usuario" 
                class="form-control" 
                required>
        </div>

        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuário:</label>
            <select 
                id="tipo_usuario" 
                name="tipo_usuario" 
                class="form-select" 
                required>
                <option value="">Selecione</option>
                <?php foreach ($tipos_usuarios as $tipo): ?>
                    <option value="<?= $tipo['id_tipo']; ?>" 
                        <?= isset($tipo_usuario) && $tipo_usuario == $tipo['id_tipo'] ? 'selected' : ''; ?>>
                        <?= $tipo['descricao_tipo']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Cadastrar Usuário</button>
        </div>
    </form>

    <a href="index.php?page=usuarios" class="btn btn-secondary mt-3">Voltar para a lista de usuários</a>
</div>

</body>
</html>
