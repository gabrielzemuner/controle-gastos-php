<section class="card">
    <?php render_component('section-title', ['text' => $isEditing ? 'Editar Gasto' : 'Adicionar Gasto']); ?>
    <form action="action.php" method="POST" class="section-content">
        <!-- <input type="hidden" name="action" value="add"> -->
        <input type="hidden" name="action" value="<?= $isEditing ? 'update' : 'add' ?>">
        <?php if ($isEditing): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editExpense['id']) ?>">
        <?php endif; ?>
        <div>
            <label for="description">Descrição</label>
            <!-- <input type="text" name="description" id="description" placeholder="Ex: Mercado" value="<?= htmlspecialchars($old['description'] ?? '') ?>"> -->
            <input type="text" name="description" id="description" placeholder="Ex: Mercado" value="<?= htmlspecialchars($isEditing ? $editExpense['description'] : ($old['description'] ?? '')) ?>">
        </div>
        <div>
            <label for="amount">Valor</label>
            <input type="text" name="amount" id="amount" placeholder="R$ 0,00" value="<?= htmlspecialchars($isEditing ? format_amount_input($editExpense['amount_cents']) : ($old['amount'] ?? '')) ?>">
        </div>
        <div>
            <label for="date">Data</label>
            <input type="date" name="date" id="date" value="<?= htmlspecialchars($isEditing ? $editExpense['date'] : ($old['date'] ?? $today)) ?>">
        </div>
        <div>
            <label for="category">Categoria</label>
            <select name="category" id="category">
                <option value="">Selecione</option>
                <?php foreach ($categories as $value => $label): ?>
                    <option value="<?= htmlspecialchars($value) ?>" <?= $selectedCategory === $value ? 'selected' : '' ?>>
                        <?= htmlspecialchars($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if ($isEditing): ?>
            <button class="btn btn-success">Editar</button>
            <a class="btn btn-danger" href="index.php">Cancelar</a>
        <?php else: ?>
            <button class="btn-primary">Adicionar</button>
        <?php endif; ?>
    </form>
</section>