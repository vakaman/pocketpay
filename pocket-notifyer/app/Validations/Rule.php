<?php

namespace App\Validations;

/**
 * The Rule Helper for Laravel Validations.
 *
 * @see https://laravel.com/docs/10.x/validation
 */
class Rule extends \Illuminate\Validation\Rule
{
    public const required = 'required';

    public const uuid = 'uuid';

    public const email = 'email';

    public const nullable = 'nullable';

    public const date = 'date';

    public const integer = 'integer';

    public const string = 'string';

    public const numeric = 'numeric';

    public const boolean = 'boolean';

    public const accepted = 'accepted';

    public const confirmed = 'confirmed';

    public const cpf = 'cpf';

    public const cnpj = 'cnpj';

    public const file = 'file';

    public const distinct = 'distinct';

    public const array = 'array';

    public const AlphaDash = 'alpha_dash';

    public const url = 'url';

    public const activeUrl = 'active_url';

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

    /** @example 'test' => [Rule::required, ... Rule::length(2)] */
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
