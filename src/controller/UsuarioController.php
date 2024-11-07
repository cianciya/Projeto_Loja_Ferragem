<?php

require_once '../config/database.php';
require_once '../src/models/Usuarios.php';

class UsuarioController
{
    private $usuario_model;
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
        $this->usuario_model = new Usuario($this->pdo);
    }

    public function login($email, $senha)
    {
        try {
            return $this->usuario_model->verificarLogin($email, $senha);
        } catch (Exception $e) {
            return ['message' => 'Erro ao listar usuários: ' . $e->getMessage()];
        }
    }

    public function listarUsuarios()
    {
        try {
            return $this->usuario_model->listarTodosUsuarios();
        } catch (Exception $e) {
            return ['message' => 'Erro ao listar usuários: ' . $e->getMessage()];
        }
    }

    public function obterUsuarioPorId($usuario_id)
    {
        if (!filter_var($usuario_id, FILTER_VALIDATE_INT)) {
            return ['message' => 'ID do usuário inválido'];
        }

        try {
            return $this->usuario_model->obterPorId($usuario_id);
        } catch (Exception $e) {
            return ['message' => 'Erro ao obter usuário: ' . $e->getMessage()];
        }
    }

    public function adicionarUsuario($nome, $email, $senha, $tipo_id)
    {
        if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($senha) || !filter_var($tipo_id, FILTER_VALIDATE_INT)) {
            return ['message' => 'Dados do usuário inválidos'];
        }

        try {
            $sucesso = $this->usuario_model->adicionar($nome, $email, $senha, $tipo_id);
            return $sucesso ? ['message' => 'Usuário adicionado com sucesso!'] : ['message' => 'Erro ao adicionar usuário'];
        } catch (Exception $e) {
            return ['message' => 'Erro ao adicionar usuário: ' . $e->getMessage()];
        }
    }

    public function atualizarUsuario($usuario_id, $nome, $email, $senha, $tipo_id)
    {
        if (!filter_var($usuario_id, FILTER_VALIDATE_INT) || empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($senha) || !filter_var($tipo_id, FILTER_VALIDATE_INT)) {
            return ['message' => 'Dados do usuário inválidos'];
        }

        try {
            $sucesso = $this->usuario_model->atualizar($usuario_id, $nome, $email, $senha, $tipo_id);
            return $sucesso ? ['message' => 'Usuário atualizado com sucesso!'] : ['message' => 'Erro ao atualizar usuário'];
        } catch (Exception $e) {
            return ['message' => 'Erro ao atualizar usuário: ' . $e->getMessage()];
        }
    }

    public function deletarUsuario($usuario_id)
    {
        if (!filter_var($usuario_id, FILTER_VALIDATE_INT)) {
            return ['message' => 'ID do usuário inválido'];
        }

        try {
            $sucesso = $this->usuario_model->deletar($usuario_id);
            return $sucesso ? ['message' => 'Usuário deletado com sucesso!'] : ['message' => 'Erro ao deletar usuário'];
        } catch (Exception $e) {
            return ['message' => 'Erro ao deletar usuário: ' . $e->getMessage()];
        }
    }
}
