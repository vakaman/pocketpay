<?php

namespace App\Domain\Exception\Wallet;

use App\Domain\Entity\Pocket\Wallet;

class WalletNotExistsException extends \Exception
{
    private Wallet $wallet;

    public static string $newMessage = 'The wallet you entered does not exist.';

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
