<?php
require_once '../config/database.php';
require_once '../src/model/Produto.php';
require_once '../src/controller/ProdutoController.php';

// Criação da conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

// Instanciando o controlador
$produtoController = new ProdutoController($pdo);

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
$categorias = $produtoController->listarCategorias(); // método para listar as categorias
$fornecedores = $produtoController->listarFornecedores(); // método para listar fornecedores

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <h1>Cadastrar Novo Produto</h1>

    <!-- Exibir mensagens de erro ou sucesso -->
    <?php if ($erro): ?>
        <p style="color: red;"><?= $erro; ?></p>
    <?php endif; ?>
    <?php if ($sucesso): ?>
        <p style="color: green;"><?= $sucesso; ?></p>
    <?php endif; ?>

    <!-- Formulário de Cadastro de Produto -->
    <form action="produtos-cad.php" method="POST">
        <div>
            <label for="nome_produto">Nome do Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto" required value="<?= $nome_produto ?? ''; ?>">
        </div>

        <div>
            <label for="descricao_produto">Descrição do Produto:</label>
            <textarea id="descricao_produto" name="descricao_produto" required><?= $descricao_produto ?? ''; ?></textarea>
        </div>

        <div>
            <label for="preco_produto">Preço:</label>
            <input type="number" id="preco_produto" name="preco_produto" required step="0.01" value="<?= $preco_produto ?? ''; ?>">
        </div>

        <div>
            <label for="quantidade_estoque">Quantidade em Estoque:</label>
            <input type="number" id="quantidade_estoque" name="quantidade_estoque" required value="<?= $quantidade_estoque ?? ''; ?>">
        </div>

        <div>
            <label for="id_categoria">Categoria:</label>
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Selecione</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id']; ?>" <?= isset($id_categoria) && $id_categoria == $categoria['id'] ? 'selected' : ''; ?>>
                        <?= $categoria['nome_categoria']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="id_fornecedor">Fornecedor:</label>
            <select id="id_fornecedor" name="id_fornecedor" required>
                <option value="">Selecione</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= $fornecedor['id']; ?>" <?= isset($id_fornecedor) && $id_fornecedor == $fornecedor['id'] ? 'selected' : ''; ?>>
                        <?= $fornecedor['nome_fornecedor']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <button type="submit">Cadastrar Produto</button>
        </div>
    </form>

    <a href="produtos.php">Voltar para a lista de produtos</a>
</body>
</html>