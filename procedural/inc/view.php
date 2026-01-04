<?php
function render(string $view, array $data = []): void
{
    extract($data);
    require __DIR__ . "/../views/{$view}.view.php";
}

function render_component(string $component, array $data = []): void
{
    extract($data);
    require __DIR__ . "/../components/{$component}.php";
}
