<?php

namespace App\Validations;

/**
 * The Rule Helper for Laravel Validations.
 *
 * @see https://laravel.com/docs/10.x/validation
 */
class Rule extends \Illuminate\Validation\Rule
{
    public const REQUIRED = 'required';

    public const UUID = 'uuid';

    public const EMAIL = 'email';

    public const NULLABLE = 'nullable';

    public const DATE = 'date';

    public const INTEGER = 'integer';

    public const UNSIGNED = 'gt:0';

    public const STRING = 'string';

    public const NUMERIC = 'numeric';

    public const BOOLEAN = 'boolean';

    public const ACCEPTED = 'accepted';

    public const CONFIRMED = 'confirmed';

    public const CPF = 'cpf';

    public const CNPJ = 'cnpj';

    public const FILE = 'file';

    public const DISTINCT = 'distinct';

    public const ARRAY = 'array';

    public const ALPHA_DASH = 'alpha_dash';

    public const URL = 'url';

    public const ACTIVE_URL = 'active_url';

    public static function between(int|float $start = 0, int|float $end = 100): string
    {
        return "between:{$start},{$end}";
    }

    public static function dateFormat(string $format): string
    {
        return "date_format:{$format}";
    }

    public static function digits(int $value): string
    {
        return "digits:{$value}";
    }

    public static function max(int $int): string
    {
        return "max:{$int}";
    }

    public static function mimes(array $mimesTypes): string
    {
        return 'mimes:'.implode(',', $mimesTypes);
    }

    public static function min(int $int): string
    {
        return "min:{$int}";
    }

    public static function requiredWithout(string $field): string
    {
        return "required_without:{$field}";
    }

    public static function requiredWith(string $field): string
    {
        return "required_with:{$field}";
    }

    public static function after(string $date): string
    {
        return "after:{$date}";
    }

    public static function same(string $field): string
    {
        return "same:{$field}";
    }

    public static function acceptedIf($field, $value): string
    {
        return "accepted_if:{$field}, {$value}";
    }

    /** @example 'test' => [Rule::REQUIRED, ... Rule::LENGTH(2)] */
    public static function length(int $int): array
    {
        return [self::min($int), self::max($int)];
    }

    public static function requiredIfValue(string $field, string $value): string
    {
        return "required_if:{$field},{$value}";
    }

    public static function is(string|bool|int|float|\BackedEnum $value): string
    {
        return sprintf('in:%s', $value instanceof \BackedEnum ? $value->value : $value);
    }

}
