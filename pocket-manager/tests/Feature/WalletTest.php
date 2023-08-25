<?php

namespace Tests\Feature;

use App\Domain\Entity\People\Person;
use App\Domain\Repository\PersonRepositoryInterface;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use Tests\TestCase;

class WalletTest extends TestCase
{
    public function test_can_create_a_wallet(): void
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

    public function test_can_get_a_main_wallets_client(): void
    {
        $this->mock(PersonRepositoryInterface::class)
            ->shouldReceive('needExists')
            ->once()
            ->andReturn(
                new Person(
                    id: new Uuid('fbcd05e1-9530-44e2-b0a2-de551b260c18')
                )
            );

        $this->mock(WalletRepositoryInterface::class)
            ->shouldReceive('main')
            ->once()
            ->andReturn(
                new Wallet(
                    id: new Uuid('65dacab7-375f-4628-a30b-c6c34eeb3268'),
                    main: true
                )
            );

        $response = $this->get('/api/wallet/main/person/fbcd05e1-9530-44e2-b0a2-de551b260c18');

        $response->assertJson([
            "id" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
            "money" => 0,
            "main" => true
        ]);
    }

    public function test_can_get_all_client_wallets(): void
    {
        $this->mock(WalletRepositoryInterface::class)
            ->shouldReceive('all')
            ->once()
            ->andReturn(
                Wallets::toEntityes(
                    [
                        [
                            'id' => (new Uuid('65dacab7-375f-4628-a30b-c6c34eeb3268'))->value,
                            'money' => 100,
                            'main' => true
                        ],
                        [
                            'id' => (new Uuid('4c228b3f-c995-4809-a68c-38425eec6e2b'))->value,
                            'money' => 133,
                            'main' => false
                        ]
                    ]
                )
            );

        $response = $this->get('/api/wallet/all/person/fbcd05e1-9530-44e2-b0a2-de551b260c18');

        $response->assertJson([
            [
                "id" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
                "money" => 100,
                "main" => true
            ],
            [
                "id" => "4c228b3f-c995-4809-a68c-38425eec6e2b",
                "money" => 133,
                "main" => false
            ]
        ]);
    }

    public function test_cant_create_a_wallet_with_invalid_payload(): void
    {
        $response = $this->post('/api/wallet', []);

        $response->assertJson([
            "error" => "The person field is required."
        ])->assertForbidden();
    }
}
