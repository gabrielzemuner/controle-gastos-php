<?php

function load_expenses(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }

    $json = file_get_contents($file);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

function save_expenses(string $file, array $expenses): bool
{
    $json = json_encode($expenses, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }

    return file_put_contents($file, $json) !== false;
}
