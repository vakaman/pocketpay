<?php

namespace App\Infrastructure\Mapper\Api;

use App\Infrastructure\Http\Entity\Notification\Body;
use App\Infrastructure\Http\Entity\Notification\Headers;

class Package
{
    public function __construct(
        private Headers $headers,
        private Body $body,
    ) {
    }

    public function request(): array
    {
        return [
            'headers' => $this->headers->toArray(),
            'body' => $this->body->toArray()
        ];
    }
}
