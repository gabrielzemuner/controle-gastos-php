<?php
require __DIR__ . '/../inc/functions.php';
require __DIR__ . '/../inc/data.php';
require __DIR__ . '/../inc/controller_helpers.php';

date_default_timezone_set('America/Sao_Paulo');
session_start();

$sessionData = get_flash_and_old();
$old = $sessionData['old'];
$flashError = $sessionData['flashError'];
$flashSuccess = $sessionData['flashSuccess'];

$baseData = get_base_data();
$today = $baseData['today'];
$categories = $baseData['categories'];
$expensesFile = $baseData['file'];

// request url
$filters = get_filters();
$month = $filters['month'];
$category = $filters['category'];

$expenses = load_expenses($expensesFile);
$filtered = filter_expenses($expenses, $month, $category);
$total = sum_total($filtered);
$byCategoryCents = summary_by_category($filtered);

$editData = get_edit_data($expenses);
$editExpense = $editData['editExpense'];
$isEditing = $editData['isEditing'];

$selectedCategory = $isEditing ? ($editExpense['category'] ?? '') : ($old['category'] ?? '');

$expensesPerPage = 2;
$pagination = get_pagination($filtered, $expensesPerPage);
$page = $pagination['page'];
$totalPages = $pagination['totalPages'];

$paginationUrls = get_pagination_urls($page, [
    'month' => $month,
    'category' => $category,
]);
$prevUrl = $paginationUrls['prevUrl'];
$nextUrl = $paginationUrls['nextUrl'];

// valores paginados
$filtered = $pagination['paged'];

$viewData = [
    'old' => $old,
    'flashError' => $flashError,
    'flashSuccess' => $flashSuccess,
    'today' => $today,
    'categories' => $categories,
    'month' => $month,
    'category' => $category,
    'filtered' => $filtered,
    'total' => $total,
    'byCategoryCents' => $byCategoryCents,
    'isEditing' => $isEditing,
    'editExpense' => $editExpense,
    'selectedCategory' => $selectedCategory,
    'page' => $page,
    'totalPages' => $totalPages,
    'expensesPerPage' => $expensesPerPage,
    'prevUrl' => $prevUrl,
    'nextUrl' => $nextUrl,
];
