<?php

namespace App\Infrastructure\Http\Entity\Notification;

class Package
{
    public function __construct(
        public readonly Headers $headers,
        public readonly Body $body,
    )
    {
    }
}
