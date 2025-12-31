<?php
// concentra as regras: filtrar, total, resumo

class ExpenseService
{
    public function filter(array $expenses, string $month, string $category): array
    {
        return array_values(array_filter($expenses, function (Expense $e) use ($month, $category) {
            if ($month !== '' && $e->date()->format('Y-m') !== $month) {
                return false;
            }
            if ($category !== '' && $e->category() !== $category) {
                return false;
            }
            return true;
        }));
    }

    public function total(array $expenses): Money
    {
        $cents = 0;
        foreach ($expenses as $e) {
            $cents += $e->amount()->cents();
        }
        return new Money($cents);
    }

    public function summaryByCategory(array $expenses): array
    {
        $by = [];
        foreach ($expenses as $e) {
            $cat = $e->category();
            $by[$cat] = ($by[$cat] ?? 0) + $e->amount()->cents();
        }
        arsort($by);
        return $by; // [category => cents]
    }

    public function categoryLabel(string $slug): string
    {
        return match ($slug) {
            'alimentacao' => 'Alimentação',
            'transporte'  => 'Transporte',
            'lazer'       => 'Lazer',
            default       => $slug,
        };
    }

    public function categories(): array
    {
        return [
            'alimentacao' => 'Alimentação',
            'transporte'  => 'Transporte',
            'lazer'       => 'Lazer',
        ];
    }
}
