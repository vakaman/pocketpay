<?php

namespace Tests\Feature;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Entity\Financial\Transactions;
use App\Domain\Exception\Transaction\TransactionUnauthorizedException;
use App\Domain\Exception\Wallet\WalletDontHaveFundsException;
use App\Domain\Repository\PersonServiceInterface;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Service\Interfaces\TransactionAuthorizationServiceInterface;
use App\Service\Interfaces\WalletServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_can_get_a_transaction_detail(): void
    {
        $this->mock(TransactionRepositoryInterface::class)
            ->shouldReceive('detail')
            ->once()
            ->andReturn(
                new Transaction(
                    from: new Uuid('fbcd05e1-9530-44e2-b0a2-de551b260c18'),
                    to: new Uuid('84065074-097c-480a-8313-3930407f75f1'),
                    value: new Money(100),
                    id: new Uuid('7685ceb6-292d-4fa4-a2d2-2e0a78f8dac7'),
                    createdAt: new Carbon('2023-08-12 15:00:00.000'),
                    updatedAt: new Carbon('2023-08-12 15:00:00.000')
                )
            );

        $response = $this->get('/api/transaction/7685ceb6-292d-4fa4-a2d2-2e0a78f8dac7');

        $response->assertJson([
            "transaction" => [
                "from" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
                "to" => "84065074-097c-480a-8313-3930407f75f1",
                "value" => 100,
                "id" => "7685ceb6-292d-4fa4-a2d2-2e0a78f8dac7",
                "created_at" => "2023-08-12T15:00:00.000000Z",
                "updated_at" => "2023-08-12T15:00:00.000000Z"
            ]
        ]);
    }

    public function test_not_found_transaction(): void
    {
        $this->mock(TransactionRepositoryInterface::class)
            ->shouldReceive('detail')
            ->once()
            ->andThrows(ModelNotFoundException::class);

        $response = $this->get('/api/transaction/7685ceb6-292d-4fa4-a2d2-2e0a78f8dac7');

        $response->assertNotFound();
    }

    public function test_can_get_a_transaction_history(): void
    {
        $transactions = [
            [
                'from' => 'fbcd05e1-9530-44e2-b0a2-de551b260c18',
                'to' => '1b24b5e7-81e3-406a-b065-18ff9dcd5f38',
                'value' => '199',
                'created_at' => '2008-12-15 00:00:00',
                'updated_at' => '2008-12-15 00:00:00',
                'id' => '0e3e9c6d-5dfe-4c19-a33c-2a4ed8e39e02'
            ],
            [
                'from' => 'fbcd05e1-9530-44e2-b0a2-de551b260c18',
                'to' => '8c188ab4-b828-45bd-b84a-ddeb6462acff',
                'value' => '599',
                'created_at' => '2012-12-15 00:00:00',
                'updated_at' => '2012-12-15 00:00:00',
                'id' => 'cfa5d707-53aa-430c-aa7f-b819ae870dd4'
            ]
        ];

        $this->mock(TransactionRepositoryInterface::class)
            ->shouldReceive('history')
            ->once()
            ->andReturn(
                TransactionHistory::toEntity(
                    new Transactions($transactions)
                )
            );

        $this->mock(WalletServiceInterface::class)
            ->shouldReceive('needExists', 'belongsToPerson')
            ->once()
            ->andReturn(true, true);

        $this->mock(PersonServiceInterface::class)
            ->shouldReceive('needExists')
            ->andReturnTrue();

        $response = $this
            ->get('/api/transaction/history/5cb0b7ec-07a2-4185-a8ca-ff9160ec4d2c/fbcd05e1-9530-44e2-b0a2-de551b260c18');

        $expectedHistory = [
            [
                '0e3e9c6d-5dfe-4c19-a33c-2a4ed8e39e02' => [
                    'from' => 'fbcd05e1-9530-44e2-b0a2-de551b260c18',
                    'to' => '1b24b5e7-81e3-406a-b065-18ff9dcd5f38',
                    'value' => '199',
                    'created_at' => '2008-12-15 00:00:00',
                    'updated_at' => '2008-12-15 00:00:00'
                ]
            ],
            [
                'cfa5d707-53aa-430c-aa7f-b819ae870dd4' => [
                    'from' => 'fbcd05e1-9530-44e2-b0a2-de551b260c18',
                    'to' => '8c188ab4-b828-45bd-b84a-ddeb6462acff',
                    'value' => '599',
                    'created_at' => '2012-12-15 00:00:00',
                    'updated_at' => '2012-12-15 00:00:00'
                ]
            ]
        ];

        $response->assertJson($expectedHistory);
    }

    public function test_cant_do_transaction_without_funds()
    {
        $transaction = [
            "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
            "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
            "value" => 111
        ];

        $this->mock(TransactionRepositoryInterface::class)
            ->shouldReceive('transactionAlreadyBeenDone')
            ->once()
            ->andReturnFalse();

        $this->mock(TransactionAuthorizationServiceInterface::class)
            ->shouldReceive('personCanTransferFunds')
            ->once()
            ->andReturn(true);


        $this->mock(WalletServiceInterface::class)
            ->shouldReceive('haveFunds')->shouldReceive('walletsExists')
            ->once()
            ->andReturn(true)
            ->andThrow(new WalletDontHaveFundsException(new Uuid('fbcd05e1-9530-44e2-b0a2-de551b260c18')));

        $response = $this->postJson('/api/transaction', $transaction);

        $response->assertJson([
            "error" => "The provided wallet does not have sufficient funds.",
            "wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
            "request" => [
                "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
                "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
                "value" => 111
            ]
        ])->assertForbidden();
    }

    public function test_cant_do_transfer_with_inexistent_wallet()
    {
        $transaction = [
            "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
            "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
            "value" => 111
        ];

        $this->mock(WalletRepositoryInterface::class)
            ->shouldReceive('exists')
            ->andReturn(false);

        $response = $this->postJson('/api/transaction', $transaction);

        $response->assertJson([
            "error" => "The wallet you entered does not exist.",
            "wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
            "request" => [
                "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
                "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
                "value" => 111
            ]
        ])->assertNotFound();
    }

    public function test_cant_do_transfer_when_person_unauthorized()
    {
        $transaction = [
            "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
            "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
            "value" => 111
        ];

        $this->mock(TransactionAuthorizationServiceInterface::class)
            ->shouldReceive('personCanTransferFunds')
            ->andReturn(false);

        $response = $this->postJson('/api/transaction', $transaction);

        $response->assertJson([
            "error" => "The informed individual does not have permission to perform transfers.",
            "request" => [
                "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
                "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
                "value" => 111
            ]
        ])->assertForbidden();
    }

    public function test_cant_do_transfer_when_unauthorized()
    {
        $transaction = [
            "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
            "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
            "value" => 111
        ];


        $this->mock(TransactionAuthorizationServiceInterface::class)
            ->shouldReceive('personCanTransferFunds')
            ->once()
            ->andReturn(true)
            ->shouldReceive('canTransact')
            ->andThrow(
                new TransactionUnauthorizedException(
                    new Transaction(
                        from: new Uuid(uuid: $transaction['from_wallet']),
                        to: new Uuid(uuid: $transaction['to_wallet']),
                        value: new Money($transaction['value']),
                    )
                )
            );

        $this->mock(TransactionRepositoryInterface::class)
            ->shouldReceive('transactionAlreadyBeenDone')
            ->andReturnFalse();

        $this->mock(WalletServiceInterface::class)
            ->shouldReceive('walletsExists', 'haveFunds')
            ->andReturnTrue();

        $response = $this->postJson('/api/transaction', $transaction);

        $response->assertJson([
            "error" => "The transaction was not authorized.",
            "request" => [
                "from_wallet" => "fbcd05e1-9530-44e2-b0a2-de551b260c18",
                "to_wallet" => "65dacab7-375f-4628-a30b-c6c34eeb3268",
                "value" => 111
            ]
        ])->assertForbidden();
    }
}
