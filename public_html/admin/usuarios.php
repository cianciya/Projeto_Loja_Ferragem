<?php
require_once '../../src/autoload.php';
require_once '../../config/bootstrap.php';
$usuariosController = new UsuarioController();

/**** Exclusao do usuário ****/ 
if(isset($_GET['ex'])){
    $usuariosController->deletarUsuario(intval($_GET['ex']));
    header("location: ?page=usuarios&pagina=1");
    exit;
}
/*****************************/

// Listar os usuários
$usuarios = $usuariosController->listarUsuarios();

$itens_por_pagina = 10;
$total_usuarios = count($usuarios); // Total de usuários
$total_paginas = ceil($total_usuarios / $itens_por_pagina); // Total de páginas

// Determina a página atual
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcula o limite de resultados a serem exibidos (com base na página atual)
$inicio = ($pagina_atual - 1) * $itens_por_pagina;
$fim = $inicio + $itens_por_pagina;

// Se não houver mais itens, ajusta o fim
if ($fim > $total_usuarios) {
    $fim = $total_usuarios;
}

// Ajusta o índice para os usuários
$usuarios_pagina = array_slice($usuarios, $inicio, $itens_por_pagina);

foreach ($usuarios_pagina as $key => $usuario){
    switch ($usuario['id_tipo']){
         case 1: 
             $usuarios_pagina[$key]['id_tipo'] = 'Administrador';
             break;
         case 2: 
             $usuarios_pagina[$key]['id_tipo'] = 'Gerente';
             break;
         case 3: 
             $usuarios_pagina[$key]['id_tipo'] = 'Cliente';
             break;
         case 4: 
             $usuarios_pagina[$key]['id_tipo'] = 'Funcionário';
             break;
    } 
 }

?>

<div class="container-fluid">
    <h1 class="mt-5 h1-sidebar">Usuários</h1>
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="mb-4">Tabela de Usuários</h2>
            <a href="?page=usuarios-cad" class="btn btn-primary btn-sm"><strong>Cadastrar Usuário</strong></a>
        </div>

        <!-- Tabela de Usuários -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($usuarios_pagina as $usuario) : ?>
                    <tr>
                        <td><?= $usuario['id_usuario'] ?></td>
                        <td><?= $usuario['nome_usuario'] ?></td>
                        <td><?= $usuario['email_usuario'] ?></td>
                        <td><?= $usuario['id_tipo'] ?></td>
                        <td>
                            <!-- Botões de Ação -->
                            <a href="?page=usuarios-editar&idusuario=<?=$usuario['id_usuario']?>" class="btn btn-warning btn-sm">Editar</a>
                            <a onclick="return confirm('Deseja mesmo excluir o usuário?');" href="?page=usuarios&pagina=<?=$pagina_atual?>&ex=<?=$usuario['id_usuario']?>" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<?php
require_once '../assets/componentes/paginacao.php';
echo renderPagination($total_usuarios, $itens_por_pagina, $pagina_atual, '?page=usuarios');
?>
