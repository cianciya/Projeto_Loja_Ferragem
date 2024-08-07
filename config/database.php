<?php

class Database {
    private $host = 'localhost';         // Endereço do servidor
    private $dbname = 'lojaferragens';   // Nome do banco de dados
    private $username = 'root';          // Nome de usuário do banco de dados
    private $password = '';              // Senha do banco de dados
    private $pdo;

    public function getConnection() {
        if ($this->pdo === null) {
            try {
                // Estabelecendo conexão com o banco de dados
                $this->pdo = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname}",
                    $this->username,
                    $this->password
                );

                // Configuração para lançar exceções em caso de erro
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $ex) {
                // Em caso de erro, exibe a mensagem e termina a execução
                die("Erro de conexão com o banco de dados: " . $ex->getMessage());
            }
        }
        return $this->pdo;
    }
}
