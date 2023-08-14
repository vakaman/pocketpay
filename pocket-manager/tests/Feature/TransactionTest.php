<?php

namespace Tests\Feature;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Currency\Money;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_can_receive_a_valid_transaction(): void
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
                    created_at: new Carbon('2023-08-12 15:00:00.000'),
                    updated_at: new Carbon('2023-08-12 15:00:00.000')
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

}
