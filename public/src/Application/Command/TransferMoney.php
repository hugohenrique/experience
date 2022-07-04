<?php
declare(strict_types=1);

namespace App\Application\Command;

final class TransferMoney
{
    public function __construct(
        private int $payer,
        private int $payee,
        private float $value
    ) {
        $this->payer = $payer;
        $this->payee = $payee;
        $this->value = $value;
    }

    public function payer(): int
    {
        return $this->payer;
    }

    public function payee(): int
    {
        return $this->payee;
    }

    public function value(): float
    {
        return $this->value;
    }
}