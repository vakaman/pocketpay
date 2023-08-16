<?php

namespace App\Domain\Exception\Transaction;

use App\Domain\Entity\Financial\Transaction;

class PersonUnauthorizedToDoTransferException extends \Exception
{
    public static string $newMessage = 'The informed individual does not have permission to perform transfers.';

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
        return !empty($message) ? $message : self::$newMessage;
    }

    public function getTransaction(): Transaction
    {
        if (is_array($this->transaction)) {
            return $this->transaction[0];
        }

        return $this->transaction;
    }
}
