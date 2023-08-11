<?php

namespace App\Domain\Entity\Email;

class Envelope
{
    public function __construct(
        public readonly Header $header,
        public readonly Body $body
    ) {
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
