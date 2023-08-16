<?php

namespace App\Domain\Exception;

use App\Domain\Entity\People\Person;
use App\Domain\ValueObject\Uuid;

class WalletNotBelongsToPersonException extends \Exception
{
    private Uuid $wallet;

    private Person $person;

    public static string $newMessage = 'The provided wallet does not belong to the person informed.';

    public function __construct(
        Uuid $wallet,
        Person $person,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        $this->wallet = $wallet;
        $this->person = $person;

        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return self::$newMessage;
    }

    public function getWalletUuid(): string
    {
        return $this->wallet->value;
    }

    public function getPersonUuid(): string
    {
        return $this->person->id->value;
    }
}
