<?php

namespace App\Domain\Entity\Email;

use App\Util\Sanitize;

class Body
{
    public readonly string $message;
    public readonly string $contentType;

    public function __construct(string $body, string $contentType = 'text/plain')
    {
        $this->message = Sanitize::string($body);
        $this->contentType = Sanitize::string($contentType);
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'content_type' => $this->contentType
        ];
    }
}
