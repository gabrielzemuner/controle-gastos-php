<?php
// centraliza timezone, session e requires

date_default_timezone_set('America/Sao_Paulo');
session_start();

require __DIR__ . '/src/Money.php';
require __DIR__ . '/src/Expense.php';
require __DIR__ . '/src/ExpenseRepository.php';
require __DIR__ . '/src/ExpenseService.php';

$repo = new ExpenseRepository(__DIR__ . '/data/expenses.json');
$service = new ExpenseService();
