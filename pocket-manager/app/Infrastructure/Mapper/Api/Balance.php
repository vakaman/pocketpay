<?php

namespace App\Infrastructure\Mapper\Api;

class Balance
{
    public function __construct(
        private int $balance
    ) {
    }

    public function response(): array
    {
        return [
            'balance' => $this->balance
        ];
    }
}
