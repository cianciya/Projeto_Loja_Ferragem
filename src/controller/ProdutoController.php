<?php

require_once '../config/database.php';
require_once '../src/models/Produtos.php';

class ProdutoController {
    private $produto_model;

    public function __construct($pdo) {
        // Inicializando o modelo de produto com a conexão ao banco de dados
        $this->produto_model = new Produto($pdo);
    }

    // Método para listar todos os produtos
    public function listarProdutos() {
        return $this->produto_model->listarTodosProdutos();
    }

    // Método para obter um produto por ID
    public function obterProdutoPorId($produto_id) {
        return $this->produto_model->obterPorId($produto_id);
    }

    public function obterProdutoPorCateg($categoria_id) {
        return $this->produto_model->obterPorCateg($categoria_id);
    }

    // Método para adicionar um novo produto
    public function adicionarProduto($nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id) {
        return $this->produto_model->adicionar($nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id);
    }

    // Método para atualizar um produto existente
    public function atualizarProduto($produto_id, $nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id) {
        return $this->produto_model->atualizar($produto_id, $nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id);
    }

    // Método para deletar um produto
    public function deletarProduto($produto_id) {
        return $this->produto_model->deletar($produto_id);
    }
}
?>