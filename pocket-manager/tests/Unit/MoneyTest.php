<?php

namespace Tests\Unit;

use App\Domain\Entity\Currency\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function test_can_get_real_value(): void
    {
        $money = new Money(1500);

        $realValue = $money->toReal();

        $this->assertEquals('R$ 15.00', $realValue);
    }

    public function test_can_get_a_interget_cents(): void
    {
        $money = new Money(33551122);

        $centsValue = $money->toInt();

        $this->assertEquals(33551122, $centsValue);
    }


    public function test_can_get_a_string_from_money(): void
    {
        $realValue = (string) (new Money(123654789));

        $this->assertEquals('R$ 1236547.89', $realValue);
    }
}
