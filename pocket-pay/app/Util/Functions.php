<?php

use App\Validations\Rule;
use Illuminate\Support\Facades\Validator;

if (!function_exists('ddt')) {
    function ddt(mixed ...$vars): never
    {
        echo "<pre>\n";
        print_r(!empty($vars[1]) ? $vars : $vars[0]);
        exit;
    }
}

if (!function_exists('isUuid')) {

    function isUuid(string $uuid): bool
    {
        if (Ramsey\Uuid\Uuid::isValid($uuid)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('uuidGenerate')) {
    function uuidGenerate(): string
    {
        return (Ramsey\Uuid\Uuid::uuid4())->toString();
    }
}

if (!function_exists('transaction')) {
    function transaction(Closure $callback, int $attempts = 1): mixed
    {
        return Illuminate\Support\Facades\DB::transaction($callback, $attempts);
    }
}

if (!function_exists('throw_unless_transaction')) {
    function throw_unless_transaction(
        Closure $callback,
        string|Throwable $exception = 'RuntimeException',
        mixed ...$parameters
    ): mixed {
        return throw_unless(
            transaction($callback),
            $exception,
            $parameters
        );
    }
}

if (!function_exists('validateCpf')) {
    function validateCpf(string $cpf): bool
    {
        $cpf = Validator::make(
            ['cpf' => $cpf],
            [
                'cpf' => [
                    Rule::REQUIRED,
                    Rule::CPF
                ]
            ]
        );

        return $cpf->passes();
    }
}

if (!function_exists('validateCnpj')) {
    function validateCnpj(string $cnpj)
    {
        $cnpj = Validator::make(
            ['cnpj' => $cnpj],
            [
                'cnpj' => [
                    Rule::REQUIRED,
                    Rule::CNPJ
                ]
            ]
        );

        return $cnpj->passes();
    }
}
