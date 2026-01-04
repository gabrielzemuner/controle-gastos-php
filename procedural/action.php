<?php
session_start();

require __DIR__ . '/inc/functions.php';
require __DIR__ . '/inc/data.php';
require __DIR__ . '/inc/config.php';

$action = $_POST['action'] ?? '';

try {
    // caminho do arquivo de dados 
    $arquivo = EXPENSES_FILE;

    // carrega gastos existentes
    $expenses = load_expenses($arquivo);

    if ($action === 'add') {
        $description = trim($_POST['description'] ?? '');
        $amount = trim($_POST['amount'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $category = trim($_POST['category'] ?? '');

        // dd($description);

        if ($description === '' || $amount === '' || $date === '' || $category === '') {
            throw new Exception('Preencha todos os campos');
        }

        $amountCents = format_cents($amount);

        if ($amountCents === null || $amountCents <= 0) {
            throw new Exception('Valor inválido');
        }

        // monta o array
        $expense = [
            'id' => bin2hex(random_bytes(8)),
            'description' => $description,
            'amount_cents' => $amountCents,
            'date' => $date,
            'category' => $category,
        ];

        // adiciona o novo array nos dados já existentes
        $expenses[] = $expense;

        if (!save_expenses($arquivo, $expenses)) {
            throw new Exception('Erro ao salvar os dados.');
        }

        $_SESSION['flash_success'] = "Gasto adicionado com sucesso!";
        header('Location: index.php');
        exit;
    }

    if ($action === 'delete') {
        $id = trim($_POST['id'] ?? '');

        $month = $_POST['month'] ?? '';
        $category = $_POST['category'] ?? '';

        if ($id === '') {
            throw new Exception('ID inválido');
        }

        $newExpenses = array_filter($expenses, function ($value) use ($id) {
            return $value['id'] !== $id;
        });

        $newExpenses = array_values($newExpenses);

        if (!save_expenses($arquivo, $newExpenses)) {
            throw new Exception('Erro ao salvar os dados.');
        }

        $_SESSION['flash_success'] = "Gasto apagado com sucesso!";
        header('Location: index.php?month=' . urlencode($month) . '&category=' . urlencode($category));
        exit;
    }

    if ($action === 'update') {
        $id = trim($_POST['id'] ?? '');

        if ($id === '') {
            throw new Exception('ID inválido');
        }

        $description = trim($_POST['description'] ?? '');
        $amount = trim($_POST['amount'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $category = trim($_POST['category'] ?? '');

        if ($description === '' || $amount === '' || $date === '' || $category === '') {
            throw new Exception('Preencha todos os campos');
        }

        $amountCents = format_cents($amount);

        if ($amountCents === null || $amountCents <= 0) {
            throw new Exception('Valor inválido');
        }

        // monta o array
        foreach ($expenses as &$e) {
            if ($e['id'] === $id) {
                $e['description'] = $description;
                $e['amount_cents'] = $amountCents;
                $e['date'] = $date;
                $e['category'] = $category;
                break;
            }
        }

        if (!save_expenses($arquivo, $expenses)) {
            throw new Exception('Erro ao salvar os dados.');
        }

        $_SESSION['flash_success'] = "Gasto atualizado com sucesso!";
        header('Location: index.php');
        exit;
    }

    // // ação desconhecida
    // header('Location: index.php');
    // exit;
} catch (Exception $e) {
    $_SESSION['old'] = [
        'description' => $description ?? '',
        'amount' => $amount ?? '',
        'date' => $date ?? '',
        'category' => $category ?? '',
    ];

    $_SESSION['flash_error'] = $e->getMessage();
    header('Location: index.php');
    exit;
}
