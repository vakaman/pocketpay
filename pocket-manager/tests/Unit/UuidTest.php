<?php

namespace Tests\Unit;

use App\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function test_get_exception_when_uuid_is_wrong(): void
    {
        $this->expectExceptionMessage('Inválid Uuid value');

        new Uuid(7685);
    }
}
