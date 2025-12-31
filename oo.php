<?php

// Exemplo 1 - Classe, objeto, ->, propriedades e métodos
class Pessoa {
    public string $nome;

    public function dizerOi(): string {
        return "Oi, eu sou " . $this->nome;
    }
}

$p1 = new Pessoa();
$p1->nome = "Gabriel";

echo $p1->dizerOi() . "<br>";

// Exemplo 2 — __construct (construtor automático)
class Pessoa2 {
    public string $nome;

    public function __construct(string $nome) {
        $this->nome = $nome;
    }

    public function dizerOi(): string {
        return "Oi, eu sou " . $this->nome;
    }
}

$p1 = new Pessoa2("Gabriel");
$p2 = new Pessoa2("Kawana");

echo $p1->dizerOi() . "<br>";
echo $p2->dizerOi() . "<br>";

// Exemplo 3 — private (encapsulamento)
class Conta {
    private float $saldo = 0;

    public function depositar(float $valor): void {
        if ($valor <= 0) {
            echo "Depósito inválido" . "<br>";
            return;
        }
        $this->saldo += $valor;
    }

    public function sacar(float $valor): void {
        if ($valor <= 0) {
            echo "Saque inválido" . "<br>";
            return;
        }
        if ($valor > $this->saldo) {
            echo "Saldo insuficiente" . "<br>";
            return;
        }
        $this->saldo -= $valor;
    }

    public function verSaldo(): float {
        return $this->saldo;
    }
}

$conta = new Conta();
$conta->depositar(100);
$conta->sacar(30);

echo $conta->verSaldo() . "<br>";

// Isso aqui seria um problema se fosse public:
// $conta->saldo = -9999;

// Exemplo 4 — static e :: (coisas da classe, não do objeto)
class Calculadora {
    public static function soma(int $a, int $b): int {
        return $a + $b;
    }
}

echo Calculadora::soma(2, 3) . "<br>";
