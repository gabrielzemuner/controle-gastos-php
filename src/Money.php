<?php

class Money
{
    private int $cents;

    public function __construct(int $cents)
    {
        if ($cents < 0) {
            throw new InvalidArgumentException("Valor não pode ser negativo.");
        }
        $this->cents = $cents;
    }

    public static function fromReais(string $value): Money
    {
        $value = trim($value);
        $value = str_replace('.', '', $value); // remove separador de milhar (1.234,56)
        $value = str_replace(',', '.', $value); // troca vírgula por ponto

        if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
            throw new InvalidArgumentException("Valor inválido.");
        }

        [$int, $dec] = array_pad(explode('.', $value, 2), 2, '0');
        $dec = str_pad($dec, 2, '0');

        $cents = ((int)$int * 100) + (int)$dec;
        return new Money($cents);
    }

    public function cents(): int
    {
        return $this->cents;
    }

    public function formatBRL(): string
    {
        $reais = intdiv($this->cents, 100);
        $centavos = $this->cents % 100;
        return 'R$ ' . $reais . ',' . str_pad((string)$centavos, 2, '0', STR_PAD_LEFT);
    }
}
