<?php

namespace App\Domain\Exception\Transaction;

use App\Domain\Entity\Financial\Transaction;

class TransactionAlreadyBeenDoneException extends \Exception
{
    public static string $newMessage = 'The provided transaction has already been completed and cannot be done again.';

    public function __construct(
        private Transaction|array $transaction,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return self::$newMessage;
    }

    public function getTransaction(): Transaction
    {
        if (is_array($this->transaction)) {
            return $this->transaction[0];
        }

        return $this->transaction;
    }
}
