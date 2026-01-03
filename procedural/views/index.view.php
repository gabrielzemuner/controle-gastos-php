<?php require __DIR__ . '/partials/header.php'; ?>

<h1 class="title">Controle de Gastos</h1>
<?php if ($flashError): ?>
    <div class="alert alert-error"><?= htmlspecialchars($flashError) ?></div>
<?php endif; ?>

<?php if ($flashSuccess): ?>
    <div class="alert alert-success"><?= htmlspecialchars($flashSuccess) ?></div>
<?php endif; ?>

<section class="card">
    <h3 class="section-title btn-primary"><?= $isEditing ? 'Editar Gasto' : 'Adicionar Gasto' ?></h3>
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

<section class="card">
    <h3 class="section-title btn-primary">Lista de Gastos</h3>
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
    <div class="section-content">
        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filtered as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['description']) ?></td>
                        <td><?= htmlspecialchars(format_brl($e['amount_cents'])) ?></td>
                        <td><?= htmlspecialchars(format_date_br($e['date'])) ?></td>
                        <td><?= htmlspecialchars($categories[$e['category']] ?? $e['category']) ?></td>

                        <td>
                            <form method="POST" action="action.php" onsubmit="return confirm('Excluir este gasto?');" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($e['id']) ?>">
                                <input type="hidden" name="month" value="<?= htmlspecialchars($month) ?>">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                                <a href="index.php?edit=<?= htmlspecialchars($e['id']) ?>" class="btn btn-warning">Editar</a>
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (count($filtered) === 0): ?>
                    <tr>
                        <td colspan="5" style="padding:16px; color:#667;">
                            Nenhum gasto cadastrado ainda.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
    <div class="section-footer">
        <div>
            Total: <?= htmlspecialchars(format_brl($total)) ?>
        </div>
        <div class="pagination">
            <a class="<?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $prevUrl ?>">Anterior</a>
            <span>Página <?= $page ?> de <?= $totalPages ?></span>
            <a class="<?= $page >= $totalPages ? 'disabled' : '' ?>" href="<?= $nextUrl ?>">Próxima</a>
        </div>


    </div>
</section>

<section class="card">
    <h3 class="section-title btn-success">Resumo do Mês</h3>
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

<?php require __DIR__ . '/partials/footer.php'; ?>