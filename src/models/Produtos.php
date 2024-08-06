<?php

    class Produto{
        private $db_connection;

        public function __construct($pdo){
            $this->db_connection = $pdo; // Instanciando a conexão
        }

        //Método para listar todos os produtos
        public function listarTodosProdutos(){
            $query = $this->db_connection->query('SELECT * FROM Produtos');
            return $query->FetchAll(PDO::FETCH_ASSOC); //Retorna um array associativo, aonde os nomes das colunas e os valores são os dados correspondentes das linhas retornadas pela consulta. 
        }

        // Método para obter um produto pelo ID
        public function obterPorId($produto_id) {
        $query = $this->db_connection->prepare('SELECT * FROM Produtos WHERE id_produto = ?');
        $query->execute([$produto_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
        }

        // Método para adicionar um novo produto
        public function adicionar($nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id) {
        $query = $this->db_connection->prepare('INSERT INTO Produtos (nome_produto, descricao_produto, preco_produto, quantidade_estoque, id_categoria, id_fornecedor) VALUES (?, ?, ?, ?, ?, ?)');
        return $query->execute([$nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id]);
        }

        // Método para atualizar um produto existente
        public function atualizar($produto_id, $nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id) {
        $query = $this->db_connection->prepare('UPDATE Produtos SET nome_produto = ?, descricao_produto = ?, preco_produto = ?, quantidade_estoque = ?, id_categoria = ?, id_fornecedor = ? WHERE id_produto = ?');
        return $query->execute([$nome, $descricao, $preco, $quantidade, $categoria_id, $fornecedor_id, $produto_id]);
        }

        // Método para deletar um produto pelo ID
        public function deletar($produto_id) {
        $query = $this->db_connection->prepare('DELETE FROM Produtos WHERE id_produto = ?');
        return $query->execute([$produto_id]);
        }
    }
?>
