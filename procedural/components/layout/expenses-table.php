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