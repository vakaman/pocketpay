<?php

namespace App\Domain\Entity\Financial;

use App\Domain\Entity\Currency\Money;
use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\ValueObject\Uuid;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class Transactions implements \Countable, \Iterator, \ArrayAccess
{
    private array $transactions = [];

    private $position = 0;

    public function __construct(array $transactions)
    {
        $this->setTransactions($transactions);
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function count(): int
    {
        return count($this->transactions);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): Transaction
    {
        return $this->transactions[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function valid(): bool
    {
        return isset($this->transactions[$this->position]);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->transactions[$offset]);
    }

    public function offsetGet($offset): Transaction
    {
        return $this->transactions[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Must be an int");
        }

        if (empty($offset)) {
            $this->transactions[] = $value;
        }

        $this->transactions[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->transactions[$offset]);
    }

    private function setTransactions(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            $this->transactions[] = new Transaction(
                id: isset($transaction->id) ? $transaction->id : new Uuid($transaction['id']),
                status: isset($transaction->status) ? $transaction->status : TransactionStatusEnum::tryFrom($transaction['status_id']),
                from: isset($transaction->from) ? $transaction->from : new Uuid($transaction['from']),
                to: isset($transaction->to) ? $transaction->to : new Uuid($transaction['to']),
                value: isset($transaction->value) ? $transaction->value : new Money($transaction['value']),
                createdAt: isset($transaction->createdAt) ? $transaction->createdAt : new Carbon($transaction['created_at']),
                updatedAt: isset($transaction->updatedAt) ? $transaction->updatedAt : new Carbon($transaction['updated_at'])
            );
        }
    }
}
