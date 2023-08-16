<?php

namespace App\Domain\Entity\Financial;

use App\Domain\Entity\Currency\Money;
use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Exception\Transaction\CannotTransferFundsToSameWalletException;
use App\Domain\Exception\Transaction\TransferValueCannotBeNegativeNumberException;
use App\Domain\Exception\Transaction\TransferValueCannotBeZeroException;
use App\Domain\ValueObject\Uuid;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid as UuidGenerator;

class Transaction
{
    public int $status;
    public readonly Uuid $id;
    public readonly Uuid $from;
    public readonly Uuid $to;
    public readonly Money $value;
    public readonly Carbon $createdAt;
    public readonly Carbon $updatedAt;

    public function __construct(
        Uuid $from,
        Uuid $to,
        Money $value,
        ?Uuid $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null,
        int $status = null
    ) {
        $this->status = $status ?? TransactionStatusEnum::PENDINIG->value;
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
        $this->id = $id ?? new Uuid((UuidGenerator::uuid4())->toString());
        $this->createdAt = $createdAt ?? Carbon::now();
        $this->updatedAt = $updatedAt ?? Carbon::now();

        $this->validations();
    }

    public static function toEntity(array $model): Transaction
    {
        return new self(
            status: $model['status_id'],
            from: new Uuid($model['from']),
            to: new Uuid($model['to']),
            value: new Money($model['value']),
            id: new Uuid($model['id']),
            createdAt: new Carbon($model['created_at']),
            updatedAt: new Carbon($model['updated_at'])
        );
    }

    public static function fromEntity(Transaction $transaction): array
    {
        return [
            "status_id" => $transaction->status,
            "from" => $transaction->from->value,
            "to" => $transaction->to->value,
            "value" => $transaction->value->toInt(),
            "id" => $transaction->id->value,
            "created_at" => $transaction->createdAt->format('Y-m-d H:i:s'),
            "updated_at" => $transaction->updatedAt->format('Y-m-d H:i:s')
        ];
    }

    public function setStatus(TransactionStatusEnum $status): bool
    {
        $this->status = $status->value;

        return true;
    }

    private function validations(): void
    {
        $this->validateValue($this->value);
        $this->validateTransferRules($this->from, $this->to);
    }

    private function validateTransferRules(Uuid $from, Uuid $to): void
    {
        $this->cannotTransferFundsToSameWallet($from, $to);
    }

    private function validateValue(Money $money): Money
    {
        $this->cannotBeNegativeNumber($money);
        $this->cannotBeZero($money);

        return $money;
    }

    private function cannotBeNegativeNumber(Money $money): void
    {
        if ($money->toInt() < 0) {
            throw new TransferValueCannotBeNegativeNumberException;
        }
    }

    private function cannotBeZero(Money $money): void
    {
        if ($money->toInt() === 0) {
            throw new TransferValueCannotBeZeroException;
        }
    }

    private function cannotTransferFundsToSameWallet(Uuid $from, Uuid $to): void
    {
        if ($from->value === $to->value) {
            throw new CannotTransferFundsToSameWalletException;
        }
    }
}
