<?php

namespace App\Infrastructure\Http\Entity\Notification;

use App\Util\Sanitize;

class Body
{
    public readonly string $content_type;
    public readonly string $message;

    public function __construct(string $content_type, string $body)
    {
        $this->content_type = Sanitize::string($content_type);
        $this->message = Sanitize::string($body);
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}