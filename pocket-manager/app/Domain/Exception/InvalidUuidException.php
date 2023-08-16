<?php

namespace App\Domain\Exception;

class InvalidUuidException extends \Exception
{
    public static string $newMessage = 'The value provided for the UUID object is invalid.';

    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(self::setMessage($message), $code, $previous);
    }

    public static function setMessage(string $message): string
    {
        return !empty($message) ? $message : self::$newMessage;
    }
}
