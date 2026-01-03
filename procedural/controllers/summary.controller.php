<?php
require __DIR__ . '/../inc/functions.php';
require __DIR__ . '/../inc/data.php';
session_start();

$arquivo = __DIR__ . '/../../data/expenses.json';
$expenses = load_expenses($arquivo);

$viewData = [
    'title' => 'Resumo',
    'expenses' => $expenses,
];
