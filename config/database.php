<?php

// Definindo os parâmetros de conexão ao banco de dados.
$db_host = 'localhost';         // Endereço do servidor
$db_name = 'lojaferragens';     // Nome do banco de dados
$db_user = 'root';              // Nome de usuário do banco de dados
$db_password = '';              // Senha do banco de dados

try {
    // Estabelecendo conexão com o banco de dados
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);

    // Configuração para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
    // Em caso de erro, exibe a mensagem e termina a execução
    die("Erro de conexão com o banco de dados: " . $ex->getMessage());
}
?>
