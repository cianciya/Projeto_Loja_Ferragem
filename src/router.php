<?php
require_once 'controller/ProdutoController.php';
require_once 'controller/UsuarioController.php';
require_once 'controller/FornecedorController.php';
require_once 'controller/CategoriaController.php';
class Router
{
    private $produtoController;
    private $usuarioController;
    private $fornecedorController;
    private $categoriaController;

    public function __construct()
    {
        // Criando uma instância da classe Database
        $database = new Database();
        $pdo = $database->getConnection();

        // Inicializando os controladores com a conexão ao banco de dados
        $this->produtoController = new ProdutoController($pdo);
        $this->usuarioController = new UsuarioController($pdo);
        $this->fornecedorController = new FornecedorController($pdo);
        $this->categoriaController = new CategoriaController($pdo);
    }
    // Verificando o caminho da requisição e executando a ação correspondente
    public function route()
    {
        $path = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($path) {
            case '/produtos':
                $this->rotaProdutos($method);
                break;
            case '/usuarios':
                $this->rotaUsuarios($method);
                break;
            case '/fornecedores':
                $this->rotaFornecedores($method);
                break;
            case '/categorias':
                $this->rotaCategorias($method);
                break;
            default:
               $this->sendJsonResponse(['message' => 'Caminho não encontrado']);
        }
    }
    // Rotas de Produtos
    private function rotaProdutos($method)
    {
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $produto = $this->produtoController->obterProdutoPorId($_GET['id']);
                   $this->sendJsonResponse($produto);
                } else {
                    $produtos = $this->produtoController->listarProdutos();
                   $this->sendJsonResponse($produtos);
                }
                break;
            case 'POST':
                $data =$this->getJsonData();
                if (isset($data['nome_produto'], $data['descricao_produto'], $data['preco_produto'], $data['quantidade_estoque'], $data['id_categoria'], $data['id_fornecedor'])) {
                    $this->produtoController->adicionarProduto(
                        $data['nome_produto'],
                        $data['descricao_produto'],
                        $data['preco_produto'],
                        $data['quantidade_estoque'],
                        $data['id_categoria'],
                        $data['id_fornecedor']
                    );
                   $this->sendJsonResponse(['message' => 'Produto adicionado com sucesso!']);
                } else {
                   $this->sendJsonResponse(['message' => 'Dados do produto incompletos']);
                }
                break;
            case 'PUT':
                $data =$this->getJsonData();
                if (isset($data['id'], $data['nome_produto'], $data['descricao_produto'], $data['preco_produto'], $data['quantidade_estoque'], $data['id_categoria'], $data['id_fornecedor'])) {
                    $this->produtoController->atualizarProduto(
                        $data['id'],
                        $data['nome_produto'],
                        $data['descricao_produto'],
                        $data['preco_produto'],
                        $data['quantidade_estoque'],
                        $data['id_categoria'],
                        $data['id_fornecedor']
                    );
                   $this->sendJsonResponse(['message' => 'Produto atualizado com sucesso!']);
                } else {
                   $this->sendJsonResponse(['message' => 'Dados do produto incompletos']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $this->produtoController->deletarProduto($_GET['id']);
                   $this->sendJsonResponse(['message' => 'Produto deletado com sucesso!']);
                } else {
                   $this->sendJsonResponse(['message' => 'ID do produto não fornecido']);
                }
                break;
            default:
               $this->sendJsonResponse(['message' => 'Método HTTP não permitido']);
        }
    }
    // Rotas de Usuários
    private function rotaUsuarios($method)
    {
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $usuario = $this->usuarioController->obterUsuarioPorId($_GET['id']);
                    $this->sendJsonResponse($usuario);
                } else {
                    $usuarios = $this->usuarioController->listarUsuarios();
                    $this->sendJsonResponse($usuarios);
                }
                break;
            case 'POST':
                $data = $this->getJsonData();
                if (isset(
                    $data['nome_usuario'],
                    $data['email_usuario'],
                    $data['senha_hash'],
                    $data['id_tipo']
                )) {
                    $this->usuarioController->adicionarUsuario(
                        $data['nome_usuario'],
                        $data['email_usuario'],
                        $data['senha_hash'],
                        $data['id_tipo']
                    );
                    $this->sendJsonResponse(['message' => 'Usuário adicionado com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'Dados do usuário incompletos']);
                }
                break;
            case 'PUT':
                $data = $this->getJsonData();
                if (isset(
                    $data['id'],
                    $data['nome_usuario'],
                    $data['email_usuario'],
                    $data['senha_hash'],
                    $data['id_tipo']
                )) {
                    $this->usuarioController->atualizarUsuario(
                        $data['id'],
                        $data['nome_usuario'],
                        $data['email_usuario'],
                        $data['senha_hash'],
                        $data['id_tipo']
                    );
                    $this->sendJsonResponse(['message' => 'Usuário atualizado com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'Dados do usuário incompletos']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $this->usuarioController->deletarUsuario($_GET['id']);
                    $this->sendJsonResponse(['message' => 'Usuário deletado com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'ID do usuário não fornecido']);
                }
                break;
            default:
                $this->sendJsonResponse(['message' => 'Método HTTP não permitido']);
        }
    }
    // Rotas de Fornecedores
    private function rotaFornecedores($method)
    {
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $fornecedor = $this->fornecedorController->obterFornecedorPorId($_GET['id']);
                    $this->sendJsonResponse($fornecedor);
                } else {
                    $fornecedores = $this->fornecedorController->listarFornecedores();
                    $this->sendJsonResponse($fornecedores);
                }
                break;
            case 'POST':
                $data = $this->getJsonData();
                if (isset(
                    $data['nome_fornecedor'],
                    $data['endereco'],
                    $data['telefone'],
                    $data['email']
                )) {
                    $this->fornecedorController->adicionarFornecedor(
                        $data['nome_fornecedor'],
                        $data['endereco'],
                        $data['telefone'],
                        $data['email']
                    );
                    $this->sendJsonResponse(['message' => 'Fornecedor adicionado com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'Dados do fornecedor incompletos']);
                }
                break;
            case 'PUT':
                $data = $this->getJsonData();
                if (isset(
                    $data['id'],
                    $data['nome_fornecedor'],
                    $data['endereco'],
                    $data['telefone'],
                    $data['email']
                )) {
                    $this->fornecedorController->atualizarFornecedor(
                        $data['id'],
                        $data['nome_fornecedor'],
                        $data['endereco'],
                        $data['telefone'],
                        $data['email']
                    );
                    $this->sendJsonResponse(['message' => 'Fornecedor atualizado com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'Dados do fornecedor incompletos']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $this->fornecedorController->deletarFornecedor($_GET['id']);
                    $this->sendJsonResponse(['message' => 'Fornecedor deletado com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'ID do fornecedor não fornecido']);
                }
                break;
            default:
                $this->sendJsonResponse(['message' => 'Método HTTP não permitido']);
        }
    }
    private function rotaCategorias($method)
    {
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $categoria = $this->categoriaController->obterCategoriaPorId($_GET['id']);
                    $this->sendJsonResponse($categoria);
                } else {
                    $categorias = $this->categoriaController->listarCategorias();
                    $this->sendJsonResponse($categorias);
                }
                break;
            case 'POST':
                $data = $this->getJsonData();
                if (isset($data['nome_categoria'])) {
                    $this->categoriaController->adicionarCategoria($data['nome_categoria']);
                    $this->sendJsonResponse(['message' => 'Categoria adicionada com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'Dados da categoria incompletos']);
                }
                break;
            case 'PUT':
                $data = $this->getJsonData();
                if (isset(
                    $data['id'],
                    $data['nome_categoria']
                )) {
                    $this->categoriaController->atualizarCategoria(
                        $data['id'],
                        $data['nome_categoria']
                    );
                    $this->sendJsonResponse(['message' => 'Categoria atualizada com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'Dados da categoria incompletos']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $this->categoriaController->deletarCategoria($_GET['id']);
                    $this->sendJsonResponse(['message' => 'Categoria deletada com sucesso!']);
                } else {
                    $this->sendJsonResponse(['message' => 'ID da categoria não fornecido']);
                }
                break;
            default:
                $this->sendJsonResponse(['message' => 'Método HTTP não permitido']);
        }
    }


    private function sendJsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    // Função para verificar se o JSON foi decodificado corretamente
    private function getJsonData()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
           $this->sendJsonResponse(['message' => 'Erro ao decodificar JSON']);
        }
        return $data;
    }
}
