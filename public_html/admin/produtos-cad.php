<?php
require_once '../../config/bootstrap.php';
require_once '../../src/autoload.php';


// Instanciando o controlador
$produtoController = new ProdutoController();
$categoria = new CategoriaController();
$fornecedores = new FornecedorController();

// Variáveis de erro
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $nome_produto = $_POST['nome_produto'] ?? '';
    $descricao_produto = $_POST['descricao_produto'] ?? '';
    $preco_produto = $_POST['preco_produto'] ?? '';
    $quantidade_estoque = $_POST['quantidade_estoque'] ?? '';
    $id_categoria = $_POST['id_categoria'] ?? '';
    $id_fornecedor = $_POST['id_fornecedor'] ?? '';

    // Validação simples
    if (empty($nome_produto) || empty($descricao_produto) || empty($preco_produto) || empty($quantidade_estoque) || empty($id_categoria) || empty($id_fornecedor)) {
        $erro = 'Todos os campos são obrigatórios!';
    } else {
        // Chamar o controlador para adicionar o produto
        try {
            $produtoController->adicionarProduto($nome_produto, $descricao_produto, $preco_produto, $quantidade_estoque, $id_categoria, $id_fornecedor);
            $sucesso = 'Produto cadastrado com sucesso!';
        } catch (Exception $e) {
            $erro = 'Erro ao cadastrar o produto: ' . $e->getMessage();
        }
    }
}

// Carregar categorias e fornecedores para os campos do formulário
$categorias = $categoria->listarCategorias(); // método para listar as categorias
$fornecedores = $fornecedores->listarFornecedores(); // método para listar fornecedores

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Produto</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Cadastrar Novo Produto</h1>

    <!-- Exibir mensagens de erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= $erro; ?></div>
    <?php endif; ?>
    <?php if ($sucesso): ?>
        <div class="alert alert-success"><?= $sucesso; ?></div>
    <?php endif; ?>

    <!-- Formulário de Cadastro de Produto -->
    <form action="#" method="POST">
        <div class="mb-3">
            <label for="nome_produto" class="form-label">Nome do Produto:</label>
            <input 
                type="text" 
                id="nome_produto" 
                name="nome_produto" 
                class="form-control" 
                required 
                value="<?= $nome_produto ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label for="descricao_produto" class="form-label">Descrição do Produto:</label>
            <textarea 
                id="descricao_produto" 
                name="descricao_produto" 
                class="form-control" 
                rows="4" 
                required><?= $descricao_produto ?? ''; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="preco_produto" class="form-label">Preço:</label>
            <input 
                type="number" 
                id="preco_produto" 
                name="preco_produto" 
                class="form-control" 
                required 
                step="0.01" 
                value="<?= $preco_produto ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label for="quantidade_estoque" class="form-label">Quantidade em Estoque:</label>
            <input 
                type="number" 
                id="quantidade_estoque" 
                name="quantidade_estoque" 
                class="form-control" 
                required 
                value="<?= $quantidade_estoque ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoria:</label>
            <select 
                id="id_categoria" 
                name="id_categoria" 
                class="form-select" 
                required>
                <option value="">Selecione</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id_categoria']; ?>" 
                        <?= isset($id_categoria) && $id_categoria == $categoria['id_categoria'] ? 'selected' : ''; ?>>
                        <?= $categoria['nome_categoria']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_fornecedor" class="form-label">Fornecedor:</label>
            <select 
                id="id_fornecedor" 
                name="id_fornecedor" 
                class="form-select" 
                required>
                <option value="">Selecione</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= $fornecedor['id_fornecedor']; ?>" 
                        <?= isset($id_fornecedor) && $id_fornecedor == $fornecedor['id_fornecedor'] ? 'selected' : ''; ?>>
                        <?= $fornecedor['nome_fornecedor']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Cadastrar Produto</button>
        </div>
    </form>

    <a href="index.php?page=produtos" class="btn btn-secondary mt-3">Voltar para a lista de produtos</a>
</div>

</body>
</html>
