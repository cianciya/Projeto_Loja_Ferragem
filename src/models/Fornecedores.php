<?php
class Fornecedor {
    private $db_connection;

    public function __construct($pdo) {
        $this->db_connection = $pdo;
    }

    public function listarTodosFornecedores() {
        $query = $this->db_connection->query('SELECT * FROM Fornecedores');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterPorId($fornecedor_id) {
        $query = $this->db_connection->prepare('SELECT * FROM Fornecedores WHERE id_fornecedor = ?');
        $query->execute([$fornecedor_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionar($nome, $endereco, $telefone, $email) {
        $query = $this->db_connection->prepare('INSERT INTO Fornecedores (nome_fornecedor, endereco, telefone, email) VALUES (?, ?, ?, ?)');
        return $query->execute([$nome, $endereco, $telefone, $email]);
    }

    public function atualizar($fornecedor_id, $nome, $endereco, $telefone, $email) {
        $query = $this->db_connection->prepare('UPDATE Fornecedores SET nome_fornecedor = ?, endereco = ?, telefone = ?, email = ? WHERE id_fornecedor = ?');
        return $query->execute([$nome, $endereco, $telefone, $email, $fornecedor_id]);
    }

    public function deletar($fornecedor_id) {
        $query = $this->db_connection->prepare('DELETE FROM Fornecedores WHERE id_fornecedor = ?');
        return $query->execute([$fornecedor_id]);
    }
}
?>
