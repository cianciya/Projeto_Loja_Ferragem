<?php

require_once '../config/database.php';
require_once '../src/controllers/ProdutoController.php';

// Inicializando o controlador de produtos com a conexão ao banco de dados
$produtoController = new ProdutoController($pdo);

// Verificando o método HTTP da requisição e executando a ação correspondente
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Caso seja uma requisição GET
        if (isset($_GET['id'])) {
            // Se um ID for fornecido, obter o produto por ID
            $produto = $produtoController->obterProdutoPorId($_GET['id']);
            echo json_encode($produto); // Retornar o produto em formato JSON
        } else {
            // Se não, listar todos os produtos
            $produtos = $produtoController->listarProdutos();
            echo json_encode($produtos); // Retornar a lista de produtos em formato JSON
        }
        break;
    case 'POST':
        // Caso seja uma requisição POST
        $data = json_decode(file_get_contents('php://input'), true); // Decodificar o JSON enviado
        $produtoController->adicionarProduto($data['nome'], $data['descricao'], $data['preco'], $data['quantidade'], $data['categoria_id'], $data['fornecedor_id']);
        echo json_encode(['message' => 'Produto adicionado com sucesso!']); // Mensagem de sucesso
        break;
    case 'PUT':
        // Caso seja uma requisição PUT
        $data = json_decode(file_get_contents('php://input'), true); // Decodificar o JSON enviado
        $produtoController->atualizarProduto($data['id'], $data['nome'], $data['descricao'], $data['preco'], $data['quantidade'], $data['categoria_id'], $data['fornecedor_id']);
        echo json_encode(['message' => 'Produto atualizado com sucesso!']); // Mensagem de sucesso
        break;
    case 'DELETE':
        // Caso seja uma requisição DELETE
        if (isset($_GET['id'])) {
            // Se um ID for fornecido, deletar o produto
            $produtoController->deletarProduto($_GET['id']);
            echo json_encode(['message' => 'Produto deletado com sucesso!']); // Mensagem de sucesso
        }
        break;
}
?>
