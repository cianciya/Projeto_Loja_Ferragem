<?php

function renderPagination($total_items, $items_per_page, $current_page, $url_base) {
    // Calcula o número total de páginas
    $total_pages = ceil($total_items / $items_per_page);

    // Não exibir nada se não houver mais de uma página
    if ($total_pages <= 1) {
        return '';
    }

    // Garante que a página atual esteja dentro dos limites
    $current_page = max(1, min($current_page, $total_pages));

    // Gerar a navegação
    $pagination_html = '<div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="...">
                                <ul class="pagination">';

    // Botão Previous
    $pagination_html .= '<li class="page-item ' . ($current_page <= 1 ? 'disabled' : '') . '">
                            <a class="page-link" href="' . ($current_page > 1 ? $url_base . '&pagina=' . ($current_page - 1) : '#') . '">Previous</a>
                          </li>';

    // Links das páginas
    for ($p = 1; $p <= $total_pages; $p++) {
        $pagination_html .= '<li class="page-item ' . ($current_page == $p ? 'active' : '') . '">
                                <a class="page-link" href="' . $url_base . '&pagina=' . $p . '">' . $p . '</a>
                              </li>';
    }

    // Botão Next
    $pagination_html .= '<li class="page-item ' . ($current_page >= $total_pages ? 'disabled' : '') . '">
                            <a class="page-link" href="' . ($current_page < $total_pages ? $url_base . '&pagina=' . ($current_page + 1) : '#') . '">Next</a>
                          </li>';

    $pagination_html .= '</ul></nav></div>';

    return $pagination_html;
}

?>
