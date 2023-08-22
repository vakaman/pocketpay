<?php

namespace Tests\Feature;

use App\Domain\Entity\People\Person;
use App\Domain\Repository\PersonRepositoryInterface;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use Tests\TestCase;

class WalletTest extends TestCase
{
    public function test_can_create_a_wallet_for_the_first_time(): void
    {
        $this->mock(PersonRepositoryInterface::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn(
                new Person(
                    id: new Uuid('fbcd05e1-9530-44e2-b0a2-de551b260c18')
                )
            );

        $this->mock(WalletRepositoryInterface::class)
            ->shouldReceive('main')
            ->once()
            ->andReturnFalse()
            ->shouldReceive('create')
            ->once()
            ->andReturn(
                new Wallet(
                    id: new Uuid('65dacab7-375f-4628-a30b-c6c34eeb3268'),
                    main: true
                )
            );

        $response = $this->post('/api/wallet', [
            "person" => "fbcd05e1-9530-44e2-b0a2-de551b260c18"
        ]);

        $response->assertJson([
            "id" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
            "money" => 0,
            "main" => true
        ]);
    }
}
