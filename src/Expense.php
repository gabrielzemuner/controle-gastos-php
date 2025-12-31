<?php

require_once __DIR__ . '/Money.php';

class Expense
{
    private string $id;
    private string $description;
    private Money $amount;
    private DateTimeImmutable $date;
    private string $category;

    public function __construct(string $description, Money $amount, DateTimeImmutable $date, string $category)
    {
        $description = trim($description);
        $category = trim($category);

        if ($description === '') {
            throw new InvalidArgumentException("Descrição é obrigatória.");
        }

        if ($category === '') {
            throw new InvalidArgumentException("Categoria é obrigatória.");
        }

        $this->id = bin2hex(random_bytes(8)); // id simples
        $this->description = $description;
        $this->amount = $amount;
        $this->date = $date;
        $this->category = $category;
    }

    // getters (só leitura)
    public function id(): string
    {
        return $this->id;
    }
    public function description(): string
    {
        return $this->description;
    }
    public function amount(): Money
    {
        return $this->amount;
    }
    public function date(): DateTimeImmutable
    {
        return $this->date;
    }
    public function category(): string
    {
        return $this->category;
    }

    // pra salvar no JSON
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'amount_cents' => $this->amount->cents(),
            'date' => $this->date->format('Y-m-d'),
            'category' => $this->category,
        ];
    }

    // pra reconstruir do JSON
    public static function fromArray(array $data): Expense
    {
        $amount = new Money((int)($data['amount_cents'] ?? 0));
        $date = new DateTimeImmutable($data['date'] ?? 'now');

        $expense = new Expense(
            (string)($data['description'] ?? ''),
            $amount,
            $date,
            (string)($data['category'] ?? '')
        );

        // mantém o id original ao carregar
        $expense->id = (string)($data['id'] ?? $expense->id);

        return $expense;
    }
}
