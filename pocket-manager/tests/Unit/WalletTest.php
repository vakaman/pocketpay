<?php

namespace Tests\Unit;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\Pocket\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function test_can_get_a_valid_wallet(): void
    {
        $money = new Money(1500);

        $wallet = new Wallet(
            'fbcd05e1-9530-44e2-b0a2-de551b260c18',
            $money,
            true
        );

        $this->assertEquals('fbcd05e1-9530-44e2-b0a2-de551b260c18', $wallet->id);
        $this->assertEquals(1500, $wallet->money->toInt());
        $this->assertEquals(true, $wallet->main);
    }
}
