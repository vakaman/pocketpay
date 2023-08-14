<?php

namespace App\Domain\Exception\Transaction;

use App\Domain\Entity\Financial\Transaction;

class TransactionFailException extends \Exception
{
    public static string $newMessage = 'Transaction failed.';

    public function __construct(private Transaction $transaction, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return self::$newMessage;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}
