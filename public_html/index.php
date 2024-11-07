<?php
require_once '../src/autoload.php';

$produtos = new ProdutoController();
if (isset($_GET['categ'])) {
    $categ = $_GET['categ'];
    $produtos = $produtos->obterProdutoPorCateg($categ);
    if (empty($produtos)) {
        echo "<script>
    alert('Não há items para essa categoria!!');
    setTimeout(function() {
        window.location.href = '../public_html/index.php';
    }, 100); // Redireciona após 1 msegundos
</script>";
        exit;
    }
} else {
    $produtos = $produtos->listarProdutos();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/style.css">
    <script src="js/event.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Loja Ferragens</title>
</head>

<body>
    <header class="background">
        <div class="menu">
            <p>Loja Ferragens</p>
            <div class="d-flex">
                <p>pesquisar</p>
                <p>carrinho</p>
            </div>
        </div>
    </header>
    <div class="container">
        <!--Seção do banner/carousel -->
        <!-- <section class="carousel">
            <div class="carousel-inner">
                <div class="carousel-item">
                    <img src="imagens/banner1200x400.jpg" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/1200x400?text=Imagem+2" alt="Banner 2">
                </div>
                <div class="carousel-item">
                    <img src="imagens/banner1200x400.jpg" alt="Banner 3">
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/1200x400?text=Imagem+4" alt="Banner 4">
                </div>
                <div class="carousel-item">
                    <img src="imagens/banner1200x400.jpg" alt="Banner 5">
                </div>
            </div>
            <button class="carousel-control prev">&#10094;</button>
            <button class="carousel-control next">&#10095;</button>
        </section>  -->
    </div>

    <div class="container">

        <aside class="background">
            <!-- <h2>Categorias</h2> -->
            <ul class="menu-list">
                <li <?php if (!isset($categ)) : ?> style="display: none" <?php endif; ?>><a href="index.php">Mostrar Todos</a></li>
                <li><a href="?categ=1"><i class="fa-solid fa-screwdriver-wrench"></i> Ferramentas</a></li>
                <li><a href="?categ=4"><i class="fas fa-bolt"></i> Eletricidade</a></li>
                <li><i class="fas fa-hammer"></i> Carpintaria</li>
                <li><i class="fas fa-cog"></i> Mecânica</li>
                <li><a href="?categ=5"><i class="fas fa-paint-brush"></i> Pintura</a></li>
                <li><a href="?categ=3"><i class="fas fa-seedling"></i> Jardinagem</a></li>
                <li><a href="?categ=2"><i class="fas fa-building"></i> Construção</a></li>
                <li><i class="fas fa-fire"></i> Soldagem</li>
                <!-- <li><i class="fas fas fa-scissors"></i> Corte</li> -->
                <li><i class="fas fa-rotate-right"></i> Perfuração</li>
                <li><i class="fas fa-screwdriver"></i> Fixação</li>
                <li><i class="fas fa-ruler"></i> Medição</li>
                <li><i class="fas fa-lightbulb"></i> Iluminação</li>
                <li><i class="fas fa-shield-alt"></i> Segurança</li>
                <li><i class="fas fa-broom"></i> Limpeza</li>
                <!-- <li><i class="fas fa-boxes"></i> Organização</li> -->
                <li><i class="fas fa-truck"></i> Transporte</li>
                <!-- <li><i class="fas fa-elevator"></i> Elevação</li> -->
                <li><i class="fas fa-pallet"></i> Materiais</li>
            </ul>
        </aside>
        <main class="background">
            <!-- Seção do banner/carousel
            <section class="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item">
                        <img src="imagens/banner1200x400.jpg" alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/1200x400?text=Imagem+2" alt="Banner 2">
                    </div>
                    <div class="carousel-item">
                        <img src="imagens/banner1200x400.jpg" alt="Banner 3">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/1200x400?text=Imagem+4" alt="Banner 4">
                    </div>
                    <div class="carousel-item">
                        <img src="imagens/banner1200x400.jpg" alt="Banner 5">
                    </div>
                </div>
                <button class="carousel-control prev">&#10094;</button>
                <button class="carousel-control next">&#10095;</button>
            </section> -->
            <section class="product-grid">
                <?php foreach ($produtos as $produto) : ?>
                    <div class="product-card">
                        <img src="<?= $produto['foto_produto'] ?>" alt="Martelo">
                        <div class="product-info">
                            <h3><?= $produto['nome_produto'] ?></h3>
                            <p class="descricao_produto"><?= $produto['descricao_produto'] ?></p>
                            <span class="price">R$<?= $produto['preco_produto'] ?></span><br><br>
                            <button class="add-to-cart">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </div>

    <footer class="azulescuro">
        Rodapé
    </footer>
</body>

</html>