<?php
require_once '../../config/bootstrap.php';
require_once '../../src/autoload.php';

$produtos = new ProdutoController();
$categoria = new CategoriaController();
$fornecedores = new FornecedorController();

$sessoes = new Sessoes();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 1) {
    header('Location: ../index.php');
}

// Obtém o ID do produto via GET
$produtoId = $_GET['idprod'] ?? null;
if (!$produtoId) {
    header('Location: ?page=produtos&pagina=1');
    exit;
}

// Busca os dados do produto no banco de dados
$produto = $produtos->obterProdutoPorId(intval($produtoId));
$categorias = $categoria->listarCategorias();
$fornecedores = $fornecedores->listarFornecedores();
$categoria = $categoria->obterCategoriaPorId($produto['id_categoria']);

if (!$produto) {
    header('Location: ?page=produtos&pagina=1');
    exit;
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = floatval($_POST['preco'] ?? 0);
    $estoque = intval($_POST['estoque'] ?? 0);
    $categoria = intval($_POST['categoria'] ?? 0);
    $fornecedor = intval($_POST['fornecedor'] ?? 0);

    $produtos->atualizarProduto($produtoId,
        $nome,
         $descricao,
         $preco,
         $estoque,
         $categoria,
         $fornecedor
    );

    // Redireciona após a atualização com uma mensagem de sucesso
    header("Location: ?page=produtos&pagina=1&edit=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Produto</title>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Editar Produto</h1>
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome_produto']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= htmlspecialchars($produto['descricao_produto']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" class="form-control" id="preco" name="preco" step="0.01" value="<?= htmlspecialchars($produto['preco_produto']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="estoque" class="form-label">Quantidade em Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" value="<?= htmlspecialchars($produto['quantidade_estoque']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-control" name="categoria" id="categoria">
                    <?php foreach ($categorias as $categ): ?>
                        <option value="<?= $categ['id_categoria'] ?>" <?= $categ['id_categoria'] == $produto['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categ['nome_categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fornecedor" class="form-label">Fornecedor</label>
                <select class="form-control" name="fornecedor" id="fornecedor">
                    <?php foreach ($fornecedores as $fornecedor): ?>
                        <option value="<?= $fornecedor['id_fornecedor'] ?>" <?= $fornecedor['id_fornecedor'] == $produto['id_fornecedor'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fornecedor['nome_fornecedor']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="?page=produtos&pagina=1" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>