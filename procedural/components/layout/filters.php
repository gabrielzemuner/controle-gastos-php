<div class="section-header">
    <form class="flex" method="GET" action="index.php">
        <div>
            <label>Filtrar por Mês</label>
            <input type="month" name="month" value="<?= htmlspecialchars($month) ?>">
        </div>

        <div>
            <label>Categoria</label>
            <select name="category">
                <option value="">Todas</option>
                <?php foreach ($categories as $value => $label): ?>
                    <option value="<?= htmlspecialchars($value) ?>" <?= $category === $value ? 'selected' : '' ?>>
                        <?= htmlspecialchars($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn-primary" type="submit">Filtrar</button>
        <a href="index.php" style="padding:8px 12px;">Limpar</a>
    </form>
</div>