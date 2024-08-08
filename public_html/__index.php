<?php

require_once '../config/database.php';
require_once '../src/controller/ProdutoController.php';
require_once '../src/controller/UsuarioController.php';
require_once '../src/controller/FornecedorController.php';
require_once '../src/controller/CategoriaController.php';

// Criando uma instância da classe Database
$database = new Database();
$pdo = $database->getConnection();

// Inicializando os controladores com a conexão ao banco de dados
$produtoController = new ProdutoController($pdo);
$usuarioController = new UsuarioController($pdo);
$fornecedorController = new FornecedorController($pdo);
$categoriaController = new CategoriaController($pdo);

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

// Verificando o caminho da requisição e executando a ação correspondente
$path = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

switch ($path) {
    // Rotas de Produtos
    case '/produtos':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $produto = $produtoController->obterProdutoPorId($_GET['id']);
                    sendJsonResponse($produto);
                } else {
                    $produtos = $produtoController->listarProdutos();
                    sendJsonResponse($produtos);
                }
                break;
            case 'POST':
                $data = getJsonData();
                if (isset($data['nome_produto'], $data['descricao_produto'], $data['preco_produto'], $data['quantidade_estoque'], $data['id_categoria'], $data['id_fornecedor'])) {
                    $produtoController->adicionarProduto(
                        $data['nome_produto'], 
                        $data['descricao_produto'], 
                        $data['preco_produto'], 
                        $data['quantidade_estoque'], 
                        $data['id_categoria'], 
                        $data['id_fornecedor']);
                    sendJsonResponse(['message' => 'Produto adicionado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados do produto incompletos']);
                }
                break;
            case 'PUT':
                $data = getJsonData();
                if (isset(
                    $data['id'], 
                    $data['nome_produto'], 
                    $data['descricao_produto'], 
                    $data['preco_produto'], 
                    $data['quantidade_estoque'], 
                    $data['id_categoria'], 
                    $data['id_fornecedor'])) {
                    $produtoController->atualizarProduto(
                        $data['id'], 
                        $data['nome_produto'], 
                        $data['descricao_produto'], 
                        $data['preco_produto'], 
                        $data['quantidade_estoque'], 
                        $data['id_categoria'], 
                        $data['id_fornecedor']);
                    sendJsonResponse(['message' => 'Produto atualizado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados do produto incompletos']);
                }
                break;
            case 'DELETE':
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
        break;

    // Rotas de Usuários
    case '/usuarios':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $usuario = $usuarioController->obterUsuarioPorId($_GET['id']);
                    sendJsonResponse($usuario);
                } else {
                    $usuarios = $usuarioController->listarUsuarios();
                    sendJsonResponse($usuarios);
                }
                break;
            case 'POST':
                $data = getJsonData();
                if (isset(
                    $data['nome_usuario'], 
                    $data['email_usuario'], 
                    $data['senha_hash'], 
                    $data['id_tipo'])) {
                    $usuarioController->adicionarUsuario(
                        $data['nome_usuario'], 
                        $data['email_usuario'], 
                        $data['senha_hash'], 
                        $data['id_tipo']);
                    sendJsonResponse(['message' => 'Usuário adicionado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados do usuário incompletos']);
                }
                break;
            case 'PUT':
                $data = getJsonData();
                if (isset(
                    $data['id'], 
                    $data['nome_usuario'], 
                    $data['email_usuario'], 
                    $data['senha_hash'], 
                    $data['id_tipo'])) {
                    $usuarioController->atualizarUsuario(
                        $data['id'], 
                        $data['nome_usuario'], 
                        $data['email_usuario'], 
                        $data['senha_hash'], 
                        $data['id_tipo']);
                    sendJsonResponse(['message' => 'Usuário atualizado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados do usuário incompletos']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $usuarioController->deletarUsuario($_GET['id']);
                    sendJsonResponse(['message' => 'Usuário deletado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'ID do usuário não fornecido']);
                }
                break;
            default:
                sendJsonResponse(['message' => 'Método HTTP não permitido']);
        }
        break;

    // Rotas de Fornecedores
    case '/fornecedores':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $fornecedor = $fornecedorController->obterFornecedorPorId($_GET['id']);
                    sendJsonResponse($fornecedor);
                } else {
                    $fornecedores = $fornecedorController->listarFornecedores();
                    sendJsonResponse($fornecedores);
                }
                break;
            case 'POST':
                $data = getJsonData();
                if (isset(
                    $data['nome_fornecedor'], 
                    $data['endereco'], 
                    $data['telefone'], 
                    $data['email'])) {
                    $fornecedorController->adicionarFornecedor(
                        $data['nome_fornecedor'], 
                        $data['endereco'], 
                        $data['telefone'], 
                        $data['email']);
                    sendJsonResponse(['message' => 'Fornecedor adicionado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados do fornecedor incompletos']);
                }
                break;
            case 'PUT':
                $data = getJsonData();
                if (isset(
                    $data['id'], 
                    $data['nome_fornecedor'], 
                    $data['endereco'], 
                    $data['telefone'], 
                    $data['email'])) {
                    $fornecedorController->atualizarFornecedor(
                        $data['id'], 
                        $data['nome_fornecedor'], 
                        $data['endereco'], 
                        $data['telefone'], 
                        $data['email']);
                    sendJsonResponse(['message' => 'Fornecedor atualizado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados do fornecedor incompletos']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $fornecedorController->deletarFornecedor($_GET['id']);
                    sendJsonResponse(['message' => 'Fornecedor deletado com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'ID do fornecedor não fornecido']);
                }
                break;
            default:
                sendJsonResponse(['message' => 'Método HTTP não permitido']);
        }
        break;

    // Rotas de Categorias
    case '/categorias':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $categoria = $categoriaController->obterCategoriaPorId($_GET['id']);
                    sendJsonResponse($categoria);
                } else {
                    $categorias = $categoriaController->listarCategorias();
                    sendJsonResponse($categorias);
                }
                break;
            case 'POST':
                $data = getJsonData();
                if (isset($data['nome_categoria'])) {
                    $categoriaController->adicionarCategoria($data['nome_categoria']);
                    sendJsonResponse(['message' => 'Categoria adicionada com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados da categoria incompletos']);
                }
                break;
            case 'PUT':
                $data = getJsonData();
                if (isset(
                    $data['id'], 
                    $data['nome_categoria'])) {
                    $categoriaController->atualizarCategoria(
                        $data['id'], 
                        $data['nome_categoria']);
                    sendJsonResponse(['message' => 'Categoria atualizada com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'Dados da categoria incompletos']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $categoriaController->deletarCategoria($_GET['id']);
                    sendJsonResponse(['message' => 'Categoria deletada com sucesso!']);
                } else {
                    sendJsonResponse(['message' => 'ID da categoria não fornecido']);
                }
                break;
            default:
                sendJsonResponse(['message' => 'Método HTTP não permitido']);
        }
        break;

    default:
        sendJsonResponse(['message' => 'Caminho não encontrado']);
}

?>
