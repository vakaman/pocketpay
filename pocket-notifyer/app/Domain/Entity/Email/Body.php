<?php

namespace App\Domain\Entity\Email;

use App\Util\Sanitize;

class Body
{
    public readonly string $message;
    public readonly string $content_type;

    public function __construct(string $body, string $content_type = 'text/plain')
    {
        $this->message = Sanitize::string($body);
        $this->content_type = Sanitize::string($content_type);
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
