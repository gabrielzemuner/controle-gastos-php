<?php
function render(string $view, array $data = []): void
{
    extract($data);
    require __DIR__ . "/../views/{$view}.view.php";
}
