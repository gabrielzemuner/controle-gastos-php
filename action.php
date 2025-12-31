<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();

require __DIR__ . '/src/Money.php';
require __DIR__ . '/src/Expense.php';
require __DIR__ . '/src/ExpenseRepository.php';

$repo = new ExpenseRepository(__DIR__ . '/data/expenses.json');

$action = $_POST['action'] ?? ''; // add | delete

try {
    if ($action === 'add') {
        $description = trim($_POST['description'] ?? '');
        $amountRaw   = trim($_POST['amount'] ?? '');
        $dateRaw     = trim($_POST['date'] ?? '');
        $category    = trim($_POST['category'] ?? '');

        if ($description === '' || $amountRaw === '' || $dateRaw === '' || $category === '') {
            throw new InvalidArgumentException("Preencha todos os campos.");
        }

        $amount = Money::fromReais($amountRaw);
        $date = new DateTimeImmutable($dateRaw);

        $expense = new Expense($description, $amount, $date, $category);
        $repo->add($expense);

        $_SESSION['flash_success'] = "Gasto adicionado com sucesso!";
        header('Location: index.php');
        exit;
    }

    if ($action === 'delete') {
        $id = trim($_POST['id'] ?? '');
        if ($id === '') {
            throw new InvalidArgumentException("ID inválido para exclusão.");
        }

        $repo->deleteById($id);

        $_SESSION['flash_success'] = "Gasto excluído!";
        $month = $_POST['month'] ?? '';
        $category = $_POST['category'] ?? '';
        header('Location: index.php?month=' . urlencode($month) . '&category=' . urlencode($category));
        exit;
    }

    // ação desconhecida
    header('Location: index.php');
    exit;
} catch (Throwable $e) {
    $_SESSION['flash_error'] = $e->getMessage();
    header('Location: index.php');
    exit;
}
