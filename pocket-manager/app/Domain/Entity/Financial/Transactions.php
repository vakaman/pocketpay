<?php

namespace App\Domain\Entity\Financial;

use App\Domain\Entity\Currency\Money;
use App\Domain\ValueObject\Uuid;
use Illuminate\Support\Carbon;

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
            throw new \InvalidArgumentException("Must be an int");
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
                from: new Uuid($transaction['from']),
                to: new Uuid($transaction['to']),
                id: new Uuid($transaction['id']),
                value: new Money($transaction['value']),
                createdAt: new Carbon($transaction['created_at']),
                updatedAt: new Carbon($transaction['updated_at'])
            );
        }
    }
}
