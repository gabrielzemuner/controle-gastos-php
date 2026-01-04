<section class="card">
    <?php render_component('section-title', ['text' => 'Lista de Gastos']); ?>
    <?php render_component('layout/filters', compact('month', 'category', 'categories')); ?>
    <?php render_component('layout/expenses-table', compact('filtered', 'categories', 'month', 'category')); ?>

    <div class="section-footer">
        <div>
            Total: <?= htmlspecialchars(format_brl($total)) ?>
        </div>
        <?php render_component('pagination', compact('page', 'totalPages', 'prevUrl', 'nextUrl')); ?>
    </div>
</section>