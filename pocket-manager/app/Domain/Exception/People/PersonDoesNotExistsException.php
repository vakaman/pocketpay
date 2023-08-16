<?php

namespace App\Domain\Exception\People;

use App\Domain\Entity\People\Person;

class PersonDoesNotExistsException extends \Exception
{
    private Person $person;

    public static string $newMessage = 'The person provided does not exist.';

    public function __construct(Person $person, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->person = $person;

        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return self::$newMessage;
    }

    public function getPerson(): Person
    {
        return $this->person;
    }
}
