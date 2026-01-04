<div class="pagination">
    <a class="<?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $prevUrl ?>">Anterior</a>
    <span>Página <?= $page ?> de <?= $totalPages ?></span>
    <a class="<?= $page >= $totalPages ? 'disabled' : '' ?>" href="<?= $nextUrl ?>">Próxima</a>
</div>