<?php

require_once  __DIR__ . '/../../config/database.php';
require_once  __DIR__ . '/../../config/Sessoes.php';
require_once  __DIR__ . '/../../src/models/TipoUsuario.php';

class TipoUsuarioController {
    private $tipo_model;

    public function __construct() {
        $database = new Database();

        $pdo = $database->getConnection();

        $this->tipo_model = new TipoUsuario($pdo);
    }

    public function listarTipo() {
        return $this->tipo_model->listarTodosTipo();
    }

    public function obterTipoPorId($tipo_id) {
        return $this->tipo_model->obterPorId($tipo_id);
    }

    public function adicionarTipo($nome) {
        return $this->tipo_model->adicionar($nome);
    }

    public function atualizarTipo($tipo_id, $nome) {
        return $this->tipo_model->atualizar($tipo_id, $nome);
    }

    public function deletarTipo($tipo_id) {
        return $this->tipo_model->deletar($tipo_id);
    }
}
?>
