<?php

namespace Tests\Feature;

use App\Domain\Entity\Currency\Money;
use App\Domain\Repository\PersonRepositoryInterface;
use App\Domain\Entity\Pocket\Wallet;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    public function test_can_receive_balance(): void
    {
        $this->mock(PersonRepositoryInterface::class)
            ->shouldReceive('getWallet')
            ->once()
            ->andReturn(
                new Wallet(
                    'fbcd05e1-9530-44e2-b0a2-de551b260c18',
                    new Money(1500),
                    true
                )
            );

        $response = $this->get('/api/balance/5cb0b7ec-07a2-4185-a8ca-ff9160ec4d2c/fbcd05e1-9530-44e2-b0a2-de551b260c18');

        $response->assertJson([
            'balance' => 1500
        ]);
    }

    public function test_cant_receive_balance(): void
    {
        $this->mock(PersonRepositoryInterface::class)
            ->shouldReceive('getWallet')
            ->once()
            ->andReturn(
                new Wallet(
                    'fbcd05e1-9530-44e2-b0a2-de551b260c18',
                    new Money(1500),
                    true
                )
            );

        $response = $this->get('/api/balance/5cb0b7ec-07a2-4185-a8ca-ff9160ec4d2c/fbcd05e1-9530-44e2-b0a2-de551b260c18');

        $response->assertJson([
            'balance' => 1500
        ]);
    }
}
