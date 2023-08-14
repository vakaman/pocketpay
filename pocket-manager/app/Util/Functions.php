<?php

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
        $uuidv4_pattern = '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/';
        if (preg_match($uuidv4_pattern, $uuid)) {
            return true;
        }

        return false;
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
            transaction($callback), $exception, $parameters
        );
    }
}
