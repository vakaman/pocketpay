<?php

namespace App\Domain\Exception;

use App\Domain\ValueObject\Uuid;

class WalletNotBelongsToPersonException extends \Exception
{
    private Uuid $wallet;

    public static string $newMessage = 'The provided wallet does not belong to the person informed.';

    public function __construct(Uuid $wallet, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->wallet = $wallet;

        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return self::$newMessage;
    }

    public function getWalletUuid(): Uuid
    {
        return $this->wallet;
    }
}
