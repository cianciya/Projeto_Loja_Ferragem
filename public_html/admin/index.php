<?php
require_once '../../config/bootstrap.php';
require_once '../../config/Sessoes.php';

$sessoes = new Sessoes();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo']  != 1) {
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <title>Administrador</title>
</head>

<body>
    <div class="fixed-top d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-100" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="fa-solid fa-user-tie fa-xl mx-2"></i>
            <span class="fs-4">Loja de Ferragens</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="?page=home" class="nav-link text-white <?php echo ($_GET['page'] ?? 'home') == 'home' ? 'active' : ''; ?>" aria-current="page">
                    <i class="fa-solid fa-house mx-2"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="?page=usuarios" class="nav-link text-white <?php echo ($_GET['page'] ?? 'home') == 'usuarios' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-user mx-2"></i>
                    Usuários
                </a>
            </li>
            <!-- <li>
                <a href="?page=orders" class="nav-link text-white <?php echo ($_GET['page'] ?? 'home') == 'orders' ? 'active' : ''; ?>">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Orders
                </a>
            </li> -->
            <li>
                <a href="?page=produtos" class="nav-link text-white <?php echo (($_GET['page'] ?? 'home') == 'produtos' || ($_GET['page'] ?? 'home') == 'produtos-cad' || ($_GET['page'] ?? 'home') == 'produtos-editar') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-screwdriver-wrench mx-2"></i>
                    Produtos
                </a>
            </li>
            <!-- <li>
                <a href="?page=customers" class="nav-link text-white <?php echo ($_GET['page'] ?? 'home') == 'customers' ? 'active' : ''; ?>">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#people-circle"></use>
                    </svg>
                    Customers
                </a>
            </li> -->
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <?php
        $page = $_GET['page'] ?? 'home';

        // Verifique se o arquivo existe e inclua o conteúdo correspondente
        $allowedPages = ['home', 'usuarios', 'produtos', 'produtos-editar','produtos-cad'];
        if (in_array($page, $allowedPages)) {
            include "$page.php";  // Inclui o arquivo com o conteúdo da página
        } else {
            include 'home.php';  // Caso contrário, carrega a página home como padrão
        }
        ?>
    </div>
</body>

</html>