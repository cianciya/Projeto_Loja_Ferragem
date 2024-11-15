<?php
require_once '../../src/autoload.php';
$produtos = new ProdutoController();

/**** Exclusao do cliente ****/ 
if(isset($_GET['ex'])){
    $produtos->deletarProduto(intval($_GET['ex']));
    echo "<script>alert('Produto excluido com sucesso');</script>";
    header("location: ?page=produtos&pagina=" . isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1);
}
/*****************************/

$produtos = $produtos->listarProdutos();

$itens_por_pagina = 10;
$total_produtos = count($produtos); // Total de produtos
$total_paginas = ceil($total_produtos / $itens_por_pagina); // Total de páginas

// Determina a página atual
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcula o limite de resultados a serem exibidos (com base na página atual)
$inicio = ($pagina_atual - 1) * $itens_por_pagina;
$fim = $inicio + $itens_por_pagina;

// Se não houver mais itens, ajusta o fim
if ($fim > $total_produtos) {
    $fim = $total_produtos;
}

// Ajusta o índice para os produtos
$produtos_pagina = array_slice($produtos, $inicio, $itens_por_pagina);

?>

<div class="container-fluid">
    <h1 class="mt-5 h1-sidebar">Produtos</h1>
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="mb-4">Tabela de Produtos</h2>
            <a href="?page=produtos-cad" class="btn btn-primary btn-sm"><strong>Cadastrar Produto</strong></a>
        </div>

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
                <?php 
                foreach ($produtos_pagina as $produto) : ?>
                    <tr>
                        <td><?= $produto['id_produto'] ?></td>
                        <td><?= $produto['nome_produto'] ?></td>
                        <td><?= $produto['descricao_produto'] ?></td>
                        <td>R$<?= $produto['preco_produto'] ?></td>
                        <td><?= $produto['quantidade_estoque'] ?></td>
                        <td>
                            <!-- Botões de Ação -->
                            <a href="?page=produtos-editar" class="btn btn-warning btn-sm">Editar</a>
                            <a onclick="return confirm('Deseja mesmo excluir o cliente?');" href="?page=produtos&pagina=<?=$pagina_atual?>&ex=<?=$produto['id_produto']?>" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<?php
require_once '../assets/componentes/paginacao.php';
echo renderPagination($total_produtos, $itens_por_pagina, $pagina_atual, '?page=produtos');
?>
