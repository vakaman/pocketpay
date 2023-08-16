<?php

namespace App\Domain\Exception\Transaction;

class CannotTransferFundsToSameWalletException extends \Exception
{
    public static string $newMessage = 'You cannot transfer funds to same wallet.';

    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return !empty($message) ? $message : self::$newMessage;
    }
}
