<?php

namespace App\Domain\Exception;

use App\Domain\ValueObject\Uuid;

class WalletDontHaveFundsException extends \Exception
{
    private Uuid $wallet;

    public static string $newMessage = 'The provided wallet does not have sufficient funds.';

    public function __construct(Uuid $wallet, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->wallet = $wallet;

        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return self::$newMessage = $message;
    }

    public function getWalletUuid(): string
    {
        return $this->wallet->value;
    }
}
