<?php
require_once '../../config/bootstrap.php';
require_once '../../config/Sessoes.php';

$sessoes = new Sessoes();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 1) {
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Administrador</title>
</head>

<body>
    <!-- Botão para abrir a sidebar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <span class="navbar-brand mb-0 h1">Administrador</span>
        </div>
    </nav>

    <!-- Sidebar como Offcanvas -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarLabel">Loja de Ferragens</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="?page=home" class="nav-link text-white <?php echo ($_GET['page'] ?? 'home') == 'home' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-house mx-2"></i> Home
                    </a>
                </li>
                <li>
                    <a href="?page=usuarios" class="nav-link text-white <?php echo (($_GET['page'] ?? 'home') == 'usuarios' || ($_GET['page'] ?? 'home') == 'usuarios-cad' || ($_GET['page'] ?? 'home') == 'usuarios-editar') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-user mx-2"></i> Usuários
                    </a>
                </li>
                <li>
                    <a href="?page=produtos" class="nav-link text-white <?php echo (($_GET['page'] ?? 'home') == 'produtos' || ($_GET['page'] ?? 'home') == 'produtos-cad' || ($_GET['page'] ?? 'home') == 'produtos-editar') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-screwdriver-wrench mx-2"></i> Produtos
                    </a>
                </li>
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
    </div>

    <!-- Conteúdo principal -->
    <div class="container mt-4">
        <?php
        $page = $_GET['page'] ?? 'home';

        // Verifique se o arquivo existe e inclua o conteúdo correspondente
        $allowedPages = ['home', 'usuarios', 'produtos', 'produtos-editar', 'produtos-cad','usuarios-cad','usuarios-editar'];
        if (in_array($page, $allowedPages)) {
            include "$page.php";  // Inclui o arquivo com o conteúdo da página
        } else {
            include 'home.php';  // Caso contrário, carrega a página home como padrão
        }
        ?>
    </div>

</body>

</html>
