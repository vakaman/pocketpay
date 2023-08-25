<?php

namespace App\Exceptions\Pocket;

use App\Domain\Entity\People\PersonAbstract;

class CannotListWalletsException extends \Exception
{
    private PersonAbstract $person;

    public static string $newMessage = 'Cannot list wallets from person.';

    public function __construct(PersonAbstract $person, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->person = $person;
        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return !empty($message) ? $message : self::$newMessage;
    }

    public function getPerson(): PersonAbstract
    {
        return $this->person;
    }
}
