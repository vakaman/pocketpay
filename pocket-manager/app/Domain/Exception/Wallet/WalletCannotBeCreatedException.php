<?php

namespace App\Domain\Exception\Wallet;

use App\Domain\Entity\People\Person;
use App\Domain\ValueObject\Uuid;

class WalletCannotBeCreatedException extends \Exception
{
    private Uuid $person;

    public static string $newMessage = 'Wallet cannot be created to person.';

    public function __construct(Person $person, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->person = $person->id;

        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return !empty($message) ? $message : self::$newMessage;
    }

    public function getWalletUuid(): string
    {
        return $this->person->value;
    }
}
