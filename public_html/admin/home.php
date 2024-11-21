<?php
require_once '../../config/bootstrap.php';
require_once '../../src/autoload.php';

// Exemplo de chamadas para dados
$produtoController = new ProdutoController();
$categoriaController = new CategoriaController();
$fornecedorController = new FornecedorController();
$usuarioController = new UsuarioController();

// Totalizadores
$produtos = $produtoController->listarProdutos(); // Assuma que retorna todos os produtos
$categorias = $categoriaController->listarCategorias();
$fornecedores = $fornecedorController->listarFornecedores();
$usuarios = $usuarioController->listarUsuarios();

$totalProdutos = count($produtos);
$totalCategorias = count($categorias);
$totalFornecedores = count($fornecedores);
$totalUsuarios = count($usuarios);

// Dados para produtos por categoria
$produtosPorCategoria = [];
foreach ($categorias as $categoria) {
    $produtosPorCategoria[] = [
        'nome_categoria' => $categoria['nome_categoria'],
        'total' => count(array_filter($produtos, fn($produto) => $produto['id_categoria'] == $categoria['id_categoria']))
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Cards de Resumo -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Produtos</h5>
                    <p class="card-text h1"><?= $totalProdutos; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Categorias</h5>
                    <p class="card-text h1"><?= $totalCategorias; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Fornecedores</h5>
                    <p class="card-text h1"><?= $totalFornecedores; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Usuários</h5>
                    <p class="card-text h1"><?= $totalUsuarios; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico e Tabela -->
    <div class="row">
        <!-- Gráfico de Produtos por Categoria -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">Produtos por Categoria</div>
                <div class="card-body">
                    <canvas id="produtosPorCategoria"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabela de Produtos -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">Últimos Produtos Cadastrados</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ultimosProdutos = array_slice($produtos, -5); // Pegando os últimos 5 produtos
                            foreach ($ultimosProdutos as $produto): ?>
                                <tr>
                                    <td><?= $produto['id_produto']; ?></td>
                                    <td><?= htmlspecialchars($produto['nome_produto']); ?></td>
                                    <td>R$ <?= number_format($produto['preco_produto'], 2, ',', '.'); ?></td>
                                    <td><?= $produto['quantidade_estoque']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados para o gráfico de produtos por categoria
    const ctx = document.getElementById('produtosPorCategoria').getContext('2d');
    const produtosPorCategoria = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($produtosPorCategoria, 'nome_categoria')); ?>,
            datasets: [{
                label: 'Quantidade de Produtos',
                data: <?= json_encode(array_column($produtosPorCategoria, 'total')); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
