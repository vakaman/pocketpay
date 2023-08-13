<?php

namespace App\Models\CastAttributes;

use App\Domain\Entity\Currency\Money as EntityMoney;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Money implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return new EntityMoney($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return (new EntityMoney($value))->toInt();
    }
}
