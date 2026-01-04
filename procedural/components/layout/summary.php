<section class="card">
    <?php render_component('section-title', ['variant' => 'success', 'text' => 'Resumo do Mês']) ?>
    <ul class="section-content">
        <li><strong>Total Geral:</strong> <?= htmlspecialchars(format_brl($total)) ?></li>

        <?php foreach ($byCategoryCents as $cat => $cents): ?>
            <li><?= htmlspecialchars($categories[$cat] ?? $cat) ?>: <?= htmlspecialchars(format_brl($cents)) ?></li>

        <?php endforeach; ?>

        <?php if (count($filtered) === 0): ?>
            <li style="color:#667;">Sem dados para o filtro atual.</li>
        <?php endif; ?>
    </ul>
</section>