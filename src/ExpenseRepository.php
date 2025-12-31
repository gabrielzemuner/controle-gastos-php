<?php

require_once __DIR__ . '/Expense.php';

class ExpenseRepository
{
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function all(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $json = file_get_contents($this->file);
        $data = json_decode($json, true);

        if (!is_array($data)) {
            return [];
        }

        return array_map(fn($row) => Expense::fromArray($row), $data);
    }

    public function add(Expense $expense): void
    {
        $items = $this->all();
        $items[] = $expense;

        $data = array_map(fn(Expense $e) => $e->toArray(), $items);

        file_put_contents(
            $this->file,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function deleteById(string $id): void
    {
        $items = $this->all();

        $items = array_values(array_filter($items, function (Expense $e) use ($id) {
            return $e->id() !== $id;
        }));

        $data = array_map(fn(Expense $e) => $e->toArray(), $items);

        file_put_contents(
            $this->file,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}
