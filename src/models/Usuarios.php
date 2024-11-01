<?php
class Usuario {
    private $db_connection;

    public function __construct($pdo) {
        $this->db_connection = $pdo;
    }

    public function verificarLogin($email, $senha){
        $senha = hash('sha256',$senha);
        try {
            $query = $this->db_connection->prepare('SELECT * FROM Usuarios WHERE email_usuario = ? AND senha_hash = ?');
            $query->execute([$email, $senha]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Trate a exceção ou registre o erro
            echo 'Erro ao encontrar usuário ' . $e->getMessage();
            return [];
        }
    }

    public function listarTodosUsuarios() {
        try {
            $query = $this->db_connection->query('SELECT * FROM Usuarios');
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Trate a exceção ou registre o erro
            echo 'Erro ao listar usuários: ' . $e->getMessage();
            return [];
        }
    }

    public function obterPorId($usuario_id) {
        if (!filter_var($usuario_id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('ID do usuário inválido');
        }

        try {
            $query = $this->db_connection->prepare('SELECT * FROM Usuarios WHERE id_usuario = ?');
            $query->execute([$usuario_id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Trate a exceção ou registre o erro
            echo 'Erro ao obter usuário: ' . $e->getMessage();
            return null;
        }
    }

    public function adicionar($nome, $email, $senha, $tipo_id) {
        // Validações básicas
        if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($senha) || !filter_var($tipo_id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('Dados do usuário inválidos');
        }

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $query = $this->db_connection->prepare('INSERT INTO Usuarios (nome_usuario, email_usuario, senha_hash, id_tipo) VALUES (?, ?, ?, ?)');
            return $query->execute([$nome, $email, $senha_hash, $tipo_id]);
        } catch (PDOException $e) {
            // Trate a exceção ou registre o erro
            echo 'Erro ao adicionar usuário: ' . $e->getMessage();
            return false;
        }
    }

    public function atualizar($usuario_id, $nome, $email, $senha, $tipo_id) {
        // Validações básicas
        if (!filter_var($usuario_id, FILTER_VALIDATE_INT) || empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($senha) || !filter_var($tipo_id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('Dados do usuário inválidos');
        }

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $query = $this->db_connection->prepare('UPDATE Usuarios SET nome_usuario = ?, email_usuario = ?, senha_hash = ?, id_tipo = ? WHERE id_usuario = ?');
            return $query->execute([$nome, $email, $senha_hash, $tipo_id, $usuario_id]);
        } catch (PDOException $e) {
            // Trate a exceção ou registre o erro
            echo 'Erro ao atualizar usuário: ' . $e->getMessage();
            return false;
        }
    }

    public function deletar($usuario_id) {
        if (!filter_var($usuario_id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('ID do usuário inválido');
        }

        try {
            $query = $this->db_connection->prepare('DELETE FROM Usuarios WHERE id_usuario = ?');
            return $query->execute([$usuario_id]);
        } catch (PDOException $e) {
            // Trate a exceção ou registre o erro
            echo 'Erro ao deletar usuário: ' . $e->getMessage();
            return false;
        }
    }
}
?>
