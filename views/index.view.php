<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Gastos</title>
    <link rel="stylesheet" href="public/style.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Controle de Gastos</h1>
        <?php if ($flashError): ?>
            <div class="alert alert-error"><?= htmlspecialchars($flashError) ?></div>
        <?php endif; ?>

        <?php if ($flashSuccess): ?>
            <div class="alert alert-success"><?= htmlspecialchars($flashSuccess) ?></div>
        <?php endif; ?>

        <section class="card">
            <h3 class="section-title bg-blue">Adicionar Gasto</h3>
            <form action="action.php" method="POST" class="section-content">
                <input type="hidden" name="action" value="add">
                <div>
                    <label for="description">Descrição</label>
                    <input type="text" name="description" id="description" placeholder="Ex: Mercado">
                </div>
                <div>
                    <label for="amount">Valor</label>
                    <input type="text" name="amount" id="amount" placeholder="R$ 0,00">
                </div>
                <div>
                    <label for="date">Data</label>
                    <input type="date" name="date" id="date" value="<?= htmlspecialchars($today) ?>">
                </div>
                <div>
                    <label for="category">Categoria</label>
                    <select name="category" id="category">
                        <?php foreach ($categories as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>">
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="bg-blue">Adicionar</button>
            </form>
        </section>

        <section class="card">
            <h3 class="section-title bg-blue">Lista de Gastos</h3>
            <div class="section-header">
                <form class="flex" method="GET" action="index.php">
                    <div>
                        <label>Filtrar por Mês</label>
                        <input type="month" name="month" value="<?= htmlspecialchars($month ?? '') ?>">
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

                    <button class="bg-blue" type="submit">Filtrar</button>
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
                                <td><?= htmlspecialchars($e->description()) ?></td>
                                <td><?= htmlspecialchars($e->amount()->formatBRL()) ?></td>
                                <td><?= htmlspecialchars($e->date()->format('d/m/Y')) ?></td>
                                <td><?= htmlspecialchars($categories[$e->category()] ?? $e->category()) ?></td>

                                <td>
                                    <form method="POST" action="action.php" onsubmit="return confirm('Excluir este gasto?');" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($e->id()) ?>">
                                        <input type="hidden" name="month" value="<?= htmlspecialchars($month) ?>">
                                        <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                                        <button type="submit" class="btn-danger">Excluir</button>
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
                Total: <?= htmlspecialchars($total->formatBRL()) ?>
            </div>
        </section>

        <section class="card">
            <h3 class="section-title bg-green">Resumo do Mês</h3>
            <ul class="section-content">
                <li><strong>Total Geral:</strong> <?= htmlspecialchars($total->formatBRL()) ?></li>

                <?php foreach ($byCategoryCents as $cat => $cents): ?>
                    <li><?= htmlspecialchars($categories[$cat] ?? $cat) ?>: <?= (new Money($cents))->formatBRL() ?></li>

                <?php endforeach; ?>

                <?php if (count($filtered) === 0): ?>
                    <li style="color:#667;">Sem dados para o filtro atual.</li>
                <?php endif; ?>
            </ul>
        </section>
    </div>
</body>

</html>