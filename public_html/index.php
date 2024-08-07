<?php

require_once '../config/database.php';
require_once '../src/controller/ProdutoController.php';

// Inicializando o controlador de produtos com a conexão ao banco de dados
$produtoController = new ProdutoController($pdo);

// Função para enviar uma resposta JSON
function sendJsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

// Função para verificar se o JSON foi decodificado corretamente
function getJsonData() {
    $data = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        sendJsonResponse(['message' => 'Erro ao decodificar JSON']);
    }
    return $data;
}

// Verificando o método HTTP da requisição e executando a ação correspondente
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Caso seja uma requisição GET
        if (isset($_GET['id'])) {
            // Se um ID for fornecido, obter o produto por ID
            $produto = $produtoController->obterProdutoPorId($_GET['id']);
            sendJsonResponse($produto); // Retornar o produto em formato JSON
        } else {
            // Se não, listar todos os produtos
            $produtos = $produtoController->listarProdutos();
            sendJsonResponse($produtos); // Retornar a lista de produtos em formato JSON
        }
        break;
    
    case 'POST':
        // Caso seja uma requisição POST
        $data = getJsonData();

        // Verificando se todos os campos necessários estão presentes
        if (isset($data['nome_produto'], $data['descricao_produto'], $data['preco_produto'], $data['quantidade_estoque'], $data['id_categoria'], $data['id_fornecedor'])) {
            $produtoController->adicionarProduto($data['nome_produto'], $data['descricao_produto'], $data['preco_produto'], $data['quantidade_estoque'], $data['id_categoria'], $data['id_fornecedor']);
            sendJsonResponse(['message' => 'Produto adicionado com sucesso!']);
        } else {
            sendJsonResponse(['message' => 'Dados do produto incompletos']);
        }
        break;
    
    case 'PUT':
        // Caso seja uma requisição PUT
        $data = getJsonData();

        // Verificando se todos os campos necessários estão presentes
        if (isset($data['id'], $data['nome_produto'], $data['descricao_produto'], $data['preco_produto'], $data['quantidade_estoque'], $data['id_categoria'], $data['id_fornecedor'])) {
            $produtoController->atualizarProduto($data['id'], $data['nome_produto'], $data['descricao_produto'], $data['preco_produto'], $data['quantidade_estoque'], $data['id_categoria'], $data['id_fornecedor']);
            sendJsonResponse(['message' => 'Produto atualizado com sucesso!']);
        } else {
            sendJsonResponse(['message' => 'Dados do produto incompletos']);
        }
        break;
    
    case 'DELETE':
        // Caso seja uma requisição DELETE
        if (isset($_GET['id'])) {
            $produtoController->deletarProduto($_GET['id']);
            sendJsonResponse(['message' => 'Produto deletado com sucesso!']);
        } else {
            sendJsonResponse(['message' => 'ID do produto não fornecido']);
        }
        break;
    
    default:
        sendJsonResponse(['message' => 'Método HTTP não permitido']);
}

?>
