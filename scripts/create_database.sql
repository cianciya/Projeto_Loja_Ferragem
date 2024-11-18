-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS LojaFerragens;

-- Uso do banco de dados
USE LojaFerragens;

-- Tabela para armazenar os tipos de usuários
CREATE TABLE TipoUsuario (
    id_tipo INT AUTO_INCREMENT PRIMARY KEY,
    descricao_tipo VARCHAR(50) NOT NULL
);

-- Inserção de Tipos de Usuário
INSERT INTO TipoUsuario (descricao_tipo) VALUES
('administrador'),
('gerente'),
('cliente'),
('funcionário');

-- Tabela para armazenar informações dos usuários
CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL,
    email_usuario VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    id_tipo INT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tipo) REFERENCES TipoUsuario(id_tipo)
);

-- Inserção de Usuários
INSERT INTO Usuarios (nome_usuario, email_usuario, senha_hash, id_tipo) VALUES
('Administrador', 'admin@loja.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1),
('Gerente', 'gerente@loja.com', 'hash_da_senha_gerente', 2),
('Cliente A', 'clientea@loja.com', 'ce5017573722eb4607f7b24ada47c006945a07109e15a161cf352f286f539c52', 3),
('Cliente B', 'clienteb@loja.com', 'hash_da_senha_cliente', 3),
('Funcionário A', 'funcionarioa@loja.com', 'hash_da_senha_funcionario', 4),
('Funcionário B', 'funcionariob@loja.com', 'hash_da_senha_funcionario', 4);

-- Tabela para armazenar categorias de produtos
CREATE TABLE Categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome_categoria VARCHAR(100) NOT NULL
);

-- Inserção de Categorias
INSERT INTO Categorias (nome_categoria) VALUES
('Ferramentas'),
('Construção'),
('Jardinagem'),
('Elétrica'),
('Pintura');

-- Tabela para armazenar informações dos fornecedores
CREATE TABLE Fornecedores (
    id_fornecedor INT AUTO_INCREMENT PRIMARY KEY,
    nome_fornecedor VARCHAR(100) NOT NULL,
    endereco VARCHAR(255),
    telefone VARCHAR(15),
    email VARCHAR(100)
);

-- Inserção de Fornecedores
INSERT INTO Fornecedores (nome_fornecedor, endereco, telefone, email) VALUES
('Fornecedor A', 'Rua A, 123', '1111-1111', 'contato@fornecedora.com'),
('Fornecedor B', 'Rua B, 456', '2222-2222', 'contato@fornecedorb.com'),
('Fornecedor C', 'Rua C, 789', '3333-3333', 'contato@fornecedorc.com');

-- Tabela para armazenar informações dos produtos
CREATE TABLE Produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(100) NOT NULL,
    descricao_produto TEXT,
    foto_produto VARCHAR(255),
    preco_produto DECIMAL(10, 2) NOT NULL,
    quantidade_estoque INT NOT NULL,
    id_categoria INT,
    id_fornecedor INT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_ativo TINYINT(1) DEFAULT 1, -- 1 para ativo, 0 para inativo
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria),
    FOREIGN KEY (id_fornecedor) REFERENCES Fornecedores(id_fornecedor)
);

-- Inserção de Produtos
INSERT INTO Produtos (nome_produto, descricao_produto, preco_produto, quantidade_estoque, id_categoria, id_fornecedor, status_ativo) VALUES
('Martelo', 'Martelo de ferro', 25.00, 100, 1, 1, 1),
('Chave de Fenda', 'Chave de fenda philips', 15.00, 200, 1, 2, 1),
('Serrote', 'Serrote para madeira', 45.00, 50, 1, 3, 1),
('Fita Métrica', 'Fita métrica de 5 metros', 10.00, 150, 1, 1, 1),
('Broca', 'Broca para perfuração', 12.00, 75, 1, 2, 1),
('Luvas de Trabalho', 'Luvas resistentes para trabalho', 8.00, 200, 1, 3, 1),
('Parafuso', 'Parafuso inoxidável', 5.00, 300, 1, 1, 1),
('Tinta Acrílica', 'Tinta acrílica para parede', 55.00, 40, 5, 2, 1),
('Pincel', 'Pincel para pintura', 7.00, 100, 5, 2, 1),
('Extensão Elétrica', 'Cabo de extensão de 10 metros', 20.00, 60, 4, 3, 1),
('Serra Elétrica', 'Serra elétrica para madeira', 250.00, 15, 1, 1, 1),
('Alicate', 'Alicate de corte', 18.00, 80, 1, 1, 1),
('Lixa', 'Lixa para madeira', 9.00, 120, 1, 2, 1),
('Tubo de PVC', 'Tubo de PVC para encanamento', 30.00, 90, 2, 3, 1),
('Conector Elétrico', 'Conector para fios elétricos', 6.00, 200, 4, 1, 1),
('Chave Inglesa', 'Chave inglesa ajustável', 22.00, 70, 1, 2, 1),
('Espátula', 'Espátula para pintura', 14.00, 85, 5, 3, 1),
('Martelo de Borracha', 'Martelo de borracha', 28.00, 55, 1, 1, 1),
('Parafuso e Porca', 'Kit de parafusos e porcas', 13.00, 180, 1, 2, 1),
('Escada', 'Escada de alumínio', 80.00, 25, 1, 1, 1);

-- Tabela para armazenar informações sobre o estoque dos produtos
CREATE TABLE Estoque (
    id_estoque INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
);

-- Inserção de Estoque
INSERT INTO Estoque (id_produto, quantidade) VALUES
(1, 100),
(2, 200),
(3, 50),
(4, 150),
(5, 75),
(6, 200),
(7, 300),
(8, 40),
(9, 100),
(10, 60),
(11, 15),
(12, 80),
(13, 120),
(14, 90),
(15, 200),
(16, 70),
(17, 85),
(18, 55),
(19, 180),
(20, 25);

-- Tabela para armazenar informações dos pedidos
CREATE TABLE Pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10, 2) NOT NULL,
    status_pedido VARCHAR(50) NOT NULL CHECK (status_pedido IN ('pendente', 'concluído', 'cancelado')),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Inserção de Pedidos
INSERT INTO Pedidos (id_usuario, valor_total, status_pedido) VALUES
(3, 100.00, 'pendente'),
(4, 250.00, 'concluído'),
(5, 50.00, 'cancelado');

-- Tabela para armazenar itens de cada pedido
CREATE TABLE ItensPedido (
    id_item_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido),
    FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
);

-- Inserção de Itens de Pedido
INSERT INTO ItensPedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES
(1, 1, 2, 25.00),
(1, 2, 1, 15.00),
(2, 3, 1, 45.00),
(2, 8, 2, 55.00),
(3, 5, 4, 12.00);

-- Tabela para armazenar o histórico de alterações de status dos produtos
CREATE TABLE HistoricoStatusProduto (
    id_historico INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    status_antigo TINYINT(1) NOT NULL,
    status_novo TINYINT(1) NOT NULL,
    data_alteracao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
);

-- Inserção de Histórico de Status de Produtos
INSERT INTO HistoricoStatusProduto (id_produto, status_antigo, status_novo) VALUES
(1, 1, 0),
(2, 1, 0),
(3, 1, 0);

-- Tabela para armazenar o histórico de preços dos produtos
CREATE TABLE HistoricoPrecosProduto (
    id_historico INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    preco_antigo DECIMAL(10, 2) NOT NULL,
    preco_novo DECIMAL(10, 2) NOT NULL,
    data_alteracao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
);

-- Inserção de Histórico de Preços de Produtos
INSERT INTO HistoricoPrecosProduto (id_produto, preco_antigo, preco_novo) VALUES
(1, 20.00, 25.00),
(2, 10.00, 15.00),
(3, 35.00, 45.00);

-- Tabela para armazenar avaliações de produtos
CREATE TABLE Avaliacoes (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    id_usuario INT NOT NULL,
    nota INT CHECK (nota BETWEEN 1 AND 5),
    comentario TEXT,
    data_avaliacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Inserção de Avaliações
INSERT INTO Avaliacoes (id_produto, id_usuario, nota, comentario) VALUES
(1, 3, 5, 'Excelente produto!'),
(2, 4, 4, 'Muito bom, mas poderia ser mais barato.'),
(3, 5, 3, 'Funciona bem, mas tem seus defeitos.');

-- Tabela para armazenar endereços dos usuários
CREATE TABLE Enderecos (
    id_endereco INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    rua VARCHAR(255),
    cidade VARCHAR(100),
    estado VARCHAR(50),
    cep VARCHAR(10),
    pais VARCHAR(50),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Inserção de Endereços
INSERT INTO Enderecos (id_usuario, rua, cidade, estado, cep, pais) VALUES
(3, 'Rua A', 'Cidade A', 'Estado A', '11111-111', 'País A'),
(4, 'Rua B', 'Cidade B', 'Estado B', '22222-222', 'País B'),
(5, 'Rua C', 'Cidade C', 'Estado C', '33333-333', 'País C');

-- Tabela para armazenar cupons de desconto
CREATE TABLE Cupons (
    id_cupom INT AUTO_INCREMENT PRIMARY KEY,
    codigo_cupom VARCHAR(50) NOT NULL UNIQUE,
    desconto DECIMAL(5, 2) NOT NULL,
    data_validade DATE NOT NULL,
    ativo TINYINT(1) DEFAULT 1
);

-- Inserção de Cupons
INSERT INTO Cupons (codigo_cupom, desconto, data_validade) VALUES
('DESCONTO10', 10.00, '2024-12-31'),
('DESCONTO20', 20.00, '2024-12-31'),
('DESCONTO30', 30.00, '2024-12-31');
