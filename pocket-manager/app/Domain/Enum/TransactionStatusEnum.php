<?php

namespace App\Domain\Enum;

enum TransactionStatusEnum: int
{
    case PENDING = 1; // recently created
    case PROCESSING = 2; // worker is processing transaction
    case SUCCESS = 3; // transaction has been done succefully
    case ERROR = 4; // something is wrong with transaction
    case UNAUTHORIZED = 5; // transaction was not authorized

    public static function alreadyBeenDone(): array
    {
        return [
            self::PROCESSING->value,
            self::SUCCESS->value,
            self::ERROR->value,
            self::UNAUTHORIZED->value
        ];
    }
}
