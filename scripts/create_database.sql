-- Criação do banco de dados
CREATE DATABASE LojaFerragens;
GO

-- Uso do banco de dados
USE LojaFerragens;
GO


-- Tabela para armazenar os tipos de usuários
CREATE TABLE TipoUsuario (
    id_tipo INT PRIMARY KEY,
    descricao_tipo NVARCHAR(50) NOT NULL
);

-- Inserção de Tipos de Usuário
INSERT INTO TipoUsuario (id_tipo, descricao_tipo) VALUES
(1, 'administrador'),
(2, 'gerente'),
(3, 'cliente'),
(4, 'funcionário');


-- Tabela para armazenar informações dos usuários
CREATE TABLE Usuarios (
    id_usuario INT IDENTITY PRIMARY KEY,
    nome_usuario NVARCHAR(100) NOT NULL,
    email_usuario NVARCHAR(100) NOT NULL UNIQUE,
    senha_hash NVARCHAR(255) NOT NULL,
    id_tipo INT NOT NULL,
    data_criacao DATETIME DEFAULT GETDATE(),
    CONSTRAINT FK_TipoUsuario FOREIGN KEY (id_tipo) REFERENCES TipoUsuario(id_tipo)
);

-- Inserção de Usuários
INSERT INTO Usuarios (nome_usuario, email_usuario, senha_hash, id_tipo) VALUES
('Administrador', 'admin@loja.com', 'hash_da_senha_admin', 1),
('Gerente', 'gerente@loja.com', 'hash_da_senha_gerente', 2),
('Cliente A', 'clientea@loja.com', 'hash_da_senha_cliente', 3),
('Cliente B', 'clienteb@loja.com', 'hash_da_senha_cliente', 3),
('Funcionário A', 'funcionarioa@loja.com', 'hash_da_senha_funcionario', 4),
('Funcionário B', 'funcionariob@loja.com', 'hash_da_senha_funcionario', 4);



-- Tabela para armazenar categorias de produtos
CREATE TABLE Categorias (
    id_categoria INT IDENTITY PRIMARY KEY,
    nome_categoria NVARCHAR(100) NOT NULL
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
    id_fornecedor INT IDENTITY PRIMARY KEY,
    nome_fornecedor NVARCHAR(100) NOT NULL,
    endereco NVARCHAR(255),
    telefone NVARCHAR(15),
    email NVARCHAR(100)
);

-- Inserção de Fornecedores
INSERT INTO Fornecedores (nome_fornecedor, endereco, telefone, email) VALUES
('Fornecedor A', 'Rua A, 123', '1111-1111', 'contato@fornecedora.com'),
('Fornecedor B', 'Rua B, 456', '2222-2222', 'contato@fornecedorb.com'),
('Fornecedor C', 'Rua C, 789', '3333-3333', 'contato@fornecedorc.com');



-- Tabela para armazenar informações dos produtos
CREATE TABLE Produtos (
    id_produto INT IDENTITY PRIMARY KEY,
    nome_produto NVARCHAR(100) NOT NULL,
    descricao_produto TEXT,
    preco_produto DECIMAL(10, 2) NOT NULL,
    quantidade_estoque INT NOT NULL,
    id_categoria INT,
    id_fornecedor INT,
    data_criacao DATETIME DEFAULT GETDATE(),
    status_ativo BIT DEFAULT 1, -- 1 para ativo, 0 para inativo
    CONSTRAINT FK_CategoriaProduto FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria),
    CONSTRAINT FK_FornecedorProduto FOREIGN KEY (id_fornecedor) REFERENCES Fornecedores(id_fornecedor)
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
    id_estoque INT IDENTITY PRIMARY KEY,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    CONSTRAINT FK_ProdutoEstoque FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
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
    id_pedido INT IDENTITY PRIMARY KEY,
    id_usuario INT NOT NULL,
    data_pedido DATETIME DEFAULT GETDATE(),
    valor_total DECIMAL(10, 2) NOT NULL,
    status_pedido NVARCHAR(50) NOT NULL CHECK (status_pedido IN ('pendente', 'concluído', 'cancelado')),
    CONSTRAINT FK_UsuarioPedido FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Inserção de Pedidos
INSERT INTO Pedidos (id_usuario, valor_total, status_pedido) VALUES
(3, 100.00, 'pendente'),
(4, 250.00, 'concluído'),
(5, 50.00, 'cancelado');



-- Tabela para armazenar itens de cada pedido
CREATE TABLE ItensPedido (
    id_item_pedido INT IDENTITY PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    CONSTRAINT FK_PedidoItem FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido),
    CONSTRAINT FK_ProdutoItem FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
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
    id_historico INT IDENTITY PRIMARY KEY,
    id_produto INT NOT NULL,
    status_antigo BIT NOT NULL,
    status_novo BIT NOT NULL,
    data_alteracao DATETIME DEFAULT GETDATE(),
    CONSTRAINT FK_ProdutoHistorico FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
);

-- Inserção de Histórico de Status de Produtos
INSERT INTO HistoricoStatusProduto (id_produto, status_antigo, status_novo) VALUES
(1, 1, 1),
(2, 1, 0),
(3, 1, 1),
(4, 1, 1),
(5, 1, 0);



-- Tabela para armazenar informações dos funcionários, incluindo status de ativação
CREATE TABLE Funcionarios (
    id_funcionario INT IDENTITY PRIMARY KEY,
    nome_funcionario NVARCHAR(100) NOT NULL,
    email_funcionario NVARCHAR(100) NOT NULL UNIQUE,
    telefone NVARCHAR(15),
    status_ativo BIT DEFAULT 1, -- 1 para ativo, 0 para inativo
    data_admissao DATETIME DEFAULT GETDATE()
);

-- Inserção de Funcionários
INSERT INTO Funcionarios (nome_funcionario, email_funcionario, telefone, status_ativo) VALUES
('Funcionario A', 'funcionarioa@loja.com', '1111-1111', 1),
('Funcionario B', 'funcionariob@loja.com', '2222-2222', 1),
('Funcionario C', 'funcionarioc@loja.com', '3333-3333', 0);



-- Tabela para armazenar imagens dos produtos
CREATE TABLE ImagensProdutos (
    id_imagem INT IDENTITY PRIMARY KEY,
    id_produto INT NOT NULL,
    imagem_produto VARBINARY(MAX),
    status_ativo BIT DEFAULT 1, -- 1 para ativo, 0 para inativo
    CONSTRAINT FK_ProdutoImagem FOREIGN KEY (id_produto) REFERENCES Produtos(id_produto)
);
