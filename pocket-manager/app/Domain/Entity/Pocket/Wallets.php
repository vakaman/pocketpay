<?php

namespace App\Domain\Entity\Pocket;

class Wallets implements \Countable, \Iterator, \ArrayAccess
{
    private array $wallets = [];

    private $position = 0;

    public function __construct(array $wallets)
    {
        $this->setWallets($wallets);
    }

    public function getWallets(): array
    {
        return $this->wallets;
    }

    public function count(): int
    {
        return count($this->wallets);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): Wallet
    {
        return $this->wallets[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function valid(): bool
    {
        return isset($this->wallets[$this->position]);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->wallets[$offset]);
    }

    public function offsetGet($offset): Wallet
    {
        return $this->wallets[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException("Must be an int");
        }

        if (empty($offset)) {
            $this->wallets[] = $value;
        }

        $this->wallets[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->wallets[$offset]);
    }

    private function setWallets(array $wallets): void
    {
        foreach ($wallets as $wallet) {
            $this->wallets[] = new Wallet(
                id: $wallet->id,
                money: $wallet->money,
                main: $wallet->main
            );
        }
    }
}
