<?php

namespace App\Exceptions\Pocket;

use App\Domain\Entity\Pocket\Wallet;

class WalletCannotBeDeletedException extends \Exception
{
    private Wallet $wallet;

    public static string $newMessage = 'Wallet cannot be deleted.';

    public function __construct(Wallet $wallet, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->wallet = $wallet;
        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return !empty($message) ? $message : self::$newMessage;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }
}
