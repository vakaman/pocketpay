<?php

namespace App\Domain\Entity\Pocket;

use App\Domain\Entity\Currency\Money;
use App\Domain\ValueObject\Uuid;

class Wallets implements \Countable, \Iterator, \ArrayAccess
{
    private array $wallets = [];

    private $position = 0;

    public function __construct(array $wallets)
    {
        $this->setWallets($wallets);
    }

    public function ids(): array
    {
        return array_map(
            fn($wallet) => $wallet->id->value,
            $this->wallets
        );
    }

    public function toArray()
    {
        return array_map(function ($wallet) {
            return $wallet::fromEntity($wallet);
        }, $this->wallets);
    }

    public static function toEntityes(array $wallets)
    {
        return new self(array_map(
            fn ($wallet) => new Wallet(
                new Uuid($wallet['id']),
                new Money($wallet['money']),
                $wallet['main']
            ),
            $wallets
        ));
    }

    public static function from(array $wallets)
    {
        self::validateIfHasOnlyWalletObjectsInArray($wallets);
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

    private static function validateIfHasOnlyWalletObjectsInArray(array $wallets)
    {
        if (!array_walk($wallets, fn ($wallet) => $wallet instanceof Wallet)) {
            throw new \Exception('The array of wallets, dont have a instance of Wallet:class valid.');
        }
    }
}
