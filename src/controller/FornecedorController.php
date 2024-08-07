<?php

require_once '../config/database.php';
require_once '../src/models/Fornecedores.php';

class FornecedorController {
    private $fornecedor_model;

    public function __construct($pdo) {
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
