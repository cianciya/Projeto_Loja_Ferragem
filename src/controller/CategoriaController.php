<?php

require_once '../config/database.php';
require_once '../src/models/Categorias.php';

class CategoriaController {
    private $categoria_model;

    public function __construct($pdo) {
        $this->categoria_model = new Categoria($pdo);
    }

    public function listarCategorias() {
        return $this->categoria_model->listarTodasCategorias();
    }

    public function obterCategoriaPorId($categoria_id) {
        return $this->categoria_model->obterPorId($categoria_id);
    }

    public function adicionarCategoria($nome) {
        return $this->categoria_model->adicionar($nome);
    }

    public function atualizarCategoria($categoria_id, $nome) {
        return $this->categoria_model->atualizar($categoria_id, $nome);
    }

    public function deletarCategoria($categoria_id) {
        return $this->categoria_model->deletar($categoria_id);
    }
}
?>