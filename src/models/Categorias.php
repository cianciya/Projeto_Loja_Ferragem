<?php
class Categoria {
    private $db_connection;

    public function __construct($pdo) {
        $this->db_connection = $pdo;
    }

    public function listarTodasCategorias() {
        $query = $this->db_connection->query('SELECT * FROM Categorias');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterPorId($categoria_id) {
        $query = $this->db_connection->prepare('SELECT * FROM Categorias WHERE id_categoria = ?');
        $query->execute([$categoria_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionar($nome) {
        $query = $this->db_connection->prepare('INSERT INTO Categorias (nome_categoria) VALUES (?)');
        return $query->execute([$nome]);
    }

    public function atualizar($categoria_id, $nome) {
        $query = $this->db_connection->prepare('UPDATE Categorias SET nome_categoria = ? WHERE id_categoria = ?');
        return $query->execute([$nome, $categoria_id]);
    }

    public function deletar($categoria_id) {
        $query = $this->db_connection->prepare('DELETE FROM Categorias WHERE id_categoria = ?');
        return $query->execute([$categoria_id]);
    }
}
?>
