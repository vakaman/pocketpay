<?php

namespace App\Util;

use App\Validations\Rule;
use Illuminate\Support\Facades\Validator;

class Sanitize
{
    public static function string(string $value): bool|string
    {
        return filter_var($value, FILTER_DEFAULT);
    }

    public static function email(string $value): bool|string
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

    public static function cnpj(string $cnpj): string
    {
        $cnpj = Validator::make($cnpj, [
            Rule::REQUIRED,
            Rule::CNPJ,
        ], ['cnpj' => 'invalid CNPJ valid']);

        return $cnpj->valid()['cnpj'];
    }
}
