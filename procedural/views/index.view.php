<?php

render_component('partials/header');

render_component('title', ['text' => 'Controle de Gastos']);

render_component('alerts', compact('flashError', 'flashSuccess'));

render_component('layout/expense-form', compact(
    'isEditing',
    'editExpense',
    'old',
    'categories',
    'selectedCategory',
    'today'
));

render_component('layout/expenses-section', compact(
    'month',
    'category',
    'categories',
    'filtered',
    'total',
    'page',
    'totalPages',
    'prevUrl',
    'nextUrl'
));

render_component('layout/summary', compact('total', 'byCategoryCents', 'categories', 'filtered'));

render_component('partials/footer');
