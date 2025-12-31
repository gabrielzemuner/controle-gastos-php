<?php
require __DIR__ . '/bootstrap.php';

// flash
$flashError = $_SESSION['flash_error'] ?? null;
$flashSuccess = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_error'], $_SESSION['flash_success']);

// dados
$expenses = $repo->all();

// filtros
$month = $_GET['month'] ?? '';
$category = $_GET['category'] ?? '';

// aplica
$filtered = $service->filter($expenses, $month, $category);
$total = $service->total($filtered);
$byCategoryCents = $service->summaryByCategory($filtered);
$categories = $service->categories();
$today = (new DateTimeImmutable())->format('Y-m-d');

// agora só renderiza a view
require __DIR__ . '/views/index.view.php';
