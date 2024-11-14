<?php
require_once '../../src/autoload.php';
$produtos = new ProdutoController();
$produtos = $produtos->listarProdutos();
?>


<div class="container-fluid">
    <h1 class="mt-5">Produtos</h1>
    <div class="container mt-5">
        <h2 class="mb-4">Tabela de Produtos</h2>

        <!-- Tabela de Produtos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($produtos as $produto) : ?>
                <tr>
                    <td><?= $produto['id_produto'] ?></td>
                    <td><?=$produto['nome_produto'] ?></td>
                    <td><?= $produto['descricao_produto'] ?></td>
                    <td>R$<?= $produto['preco_produto'] ?></td>
                    <td><?= $produto['quantidade_estoque'] ?></td>
                    <td>
                        <!-- Botões de Ação -->
                        <button class="btn btn-warning btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm">Excluir</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <!-- Adicione mais linhas conforme necessário -->
            </tbody>
        </table>
    </div>
</div>