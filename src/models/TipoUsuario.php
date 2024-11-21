<?php
class TipoUsuario {
    private $db_connection;

    public function __construct($pdo) {
        $this->db_connection = $pdo;
    }

    public function listarTodosTipo() {
        $query = $this->db_connection->query('SELECT * FROM tipousuario');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterPorId($categoria_id) {
        $query = $this->db_connection->prepare('SELECT * FROM tipousuario WHERE id_tipo = ?');
        $query->execute([$categoria_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionar($nome) {
        $query = $this->db_connection->prepare('INSERT INTO tipousuario (descricao_tipo) VALUES (?)');
        return $query->execute([$nome]);
    }

    public function atualizar($categoria_id, $nome) {
        $query = $this->db_connection->prepare('UPDATE tipousuario SET descricao_tipo = ? WHERE id_tipo = ?');
        return $query->execute([$nome, $categoria_id]);
    }

    public function deletar($categoria_id) {
        $query = $this->db_connection->prepare('DELETE FROM tipousuario WHERE id_tipo = ?');
        return $query->execute([$categoria_id]);
    }
}
?>
