<?php

namespace App\Util;

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
}
