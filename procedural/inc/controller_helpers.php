<?php
require __DIR__ . '/config.php';

function get_flash_and_old(): array
{
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);

    $flashError = $_SESSION['flash_error'] ?? null;
    $flashSuccess = $_SESSION['flash_success'] ?? null;
    unset($_SESSION['flash_error'], $_SESSION['flash_success']);

    // return [
    //     'old' => $old,
    //     'flashError' => $flashError,
    //     'flashSuccess' => $flashSuccess,
    // ];

    return compact('old', 'flashError', 'flashSuccess');
}

function get_base_data(): array
{
    return [
        'today' => date('Y-m-d'),
        'categories' => categories(),
        'file' => EXPENSES_FILE,
    ];
}

function get_filters(): array
{
    return [
        'month' => $_GET['month'] ?? '',
        'category' => $_GET['category'] ?? '',
    ];
}

function get_edit_data(array $expenses): array
{
    $editId = $_GET['edit'] ?? '';
    $editExpense = null;

    foreach ($expenses as $e) {
        if ($e['id'] === $editId) {
            $editExpense = $e;
            break;
        }
    }

    return [
        'editId' => $editId,
        'editExpense' => $editExpense,
        'isEditing' => $editExpense !== null,
    ];
}

function get_pagination(array $items, int $perPage): array
{
    $page = $_GET['page'] ?? 1;
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $perPage;
    $totalPages = max(1, ceil(count($items) / $perPage)); // garantir mínimo 1 no resultado
    $paged = array_slice($items, $offset, $perPage);

    return compact('page', 'offset', 'totalPages', 'paged');
}

function get_pagination_urls(int $page, array $params = []): array
{
    $paramUrl = '';

    foreach ($params as $key => $value) {
        if ($value !== '') {
            $paramUrl .= '&' . $key . '=' . urlencode($value);
        }
    }

    $prevUrl = 'index.php?page=' . ($page - 1) . $paramUrl;
    $nextUrl = 'index.php?page=' . ($page + 1) . $paramUrl;

    return compact('prevUrl', 'nextUrl');
}
