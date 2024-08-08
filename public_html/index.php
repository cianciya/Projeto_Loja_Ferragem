<?php

require_once '../config/database.php';
require_once '../src/router.php';

// Executa a classe router
$router = new Router();
$router->route();

?>
