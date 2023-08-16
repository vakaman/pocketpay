<?php

namespace App\Models\CastAttributes;

use App\Domain\ValueObject\Uuid as ValueObjectUuid;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Uuid implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ValueObjectUuid
    {
        return new ValueObjectUuid($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if ($value instanceof ValueObjectUuid) {
            return $value->value;
        }

        return (new ValueObjectUuid($value))->value;
    }
}
