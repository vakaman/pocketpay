<?php

namespace App\Domain\Entity\Currency;

class Money
{
    private readonly int $cents;

    public function __construct(int $cents)
    {
        $this->cents = $cents;
    }

    public function __toString(): string
    {
        return $this->toReal();
    }

    public function toInt(): int
    {
        return $this->cents;
    }

    public function toReal(): string
    {
        return "R$ " . number_format(($this->cents / 100), 2, '.', '');
    }
}
