<?php

require_once  __DIR__ . '/../../config/database.php';
require_once  __DIR__ . '/../../config/Sessoes.php';
require_once  __DIR__ . '/../../src/models/Fornecedores.php';

class FornecedorController {
    private $fornecedor_model;

    public function __construct() {
        $database = new Database();

        $pdo = $database->getConnection();

        $this->fornecedor_model = new Fornecedor($pdo);
    }

    public function listarFornecedores() {
        return $this->fornecedor_model->listarTodosFornecedores();
    }

    public function obterFornecedorPorId($fornecedor_id) {
        return $this->fornecedor_model->obterPorId($fornecedor_id);
    }

    public function adicionarFornecedor($nome, $endereco, $telefone, $email) {
        return $this->fornecedor_model->adicionar($nome, $endereco, $telefone, $email);
    }

    public function atualizarFornecedor($fornecedor_id, $nome, $endereco, $telefone, $email) {
        return $this->fornecedor_model->atualizar($fornecedor_id, $nome, $endereco, $telefone, $email);
    }

    public function deletarFornecedor($fornecedor_id) {
        return $this->fornecedor_model->deletar($fornecedor_id);
    }
}
?>
