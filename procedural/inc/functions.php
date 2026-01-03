<?php
function categories(): array
{
    return [
        'alimentacao' => 'Alimentação',
        'transporte'  => 'Transporte',
        'lazer'       => 'Lazer',
    ];
}

function format_cents($amount): ?int
{
    // remover pontos
    $amount = str_replace('.', '', $amount);
    // trocar vírgula por ponto
    $amount = str_replace(',', '.', $amount);

    if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
        return null; // ou false, ou lançar erro
    }

    list($int, $dec) = array_pad(explode('.', $amount, 2), 2, '0');
    $dec = str_pad($dec, 2, '0');

    $centavos = ((int)$int * 100) + (int)$dec;

    return $centavos;
}

function format_brl(int $cents): string
{
    $reais = intdiv($cents, 100);
    $centavos = $cents % 100;
    return 'R$ ' . $reais . ',' . str_pad((string)$centavos, 2, '0', STR_PAD_LEFT);
}

function format_amount_input(int $cents): string
{
    $value = $cents / 100;
    return number_format($value, 2, ',', '');
}


function format_date_br(?string $date): string
{
    // se $date vazio ex $date = '' -> retorna ''
    if (!$date) {
        return '';
    }

    // se $date inválido ex $date = 'aaaa-bb-cc' -> retorna ''
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return '';
    }

    return date('d/m/Y', $timestamp);
}

function filter_expenses(array $expenses, string $month, string $category): array
{
    return array_values(array_filter($expenses, function ($e) use ($month, $category) {
        if ($month !== '' && substr($e['date'], 0, 7) !== $month) {
            return false;
        }
        if ($category !== '' && $e['category'] !== $category) {
            return false;
        }
        return true;
    }));
}

function sum_total(array $expenses): int
{
    $total = 0;
    foreach ($expenses as $e) {
        $total += $e['amount_cents'];
    }
    return $total;
}

function summary_by_category(array $expenses): array
{
    $byCategoryCents = [];
    foreach ($expenses as $e) {
        $cat = $e['category'];
        if (!isset($byCategoryCents[$cat])) {
            $byCategoryCents[$cat] = 0;
        }
        $byCategoryCents[$cat] += $e['amount_cents'];
    }
    arsort($byCategoryCents);
    return $byCategoryCents;
}

function dd($value): void {
    var_dump($value);
    exit;
}
