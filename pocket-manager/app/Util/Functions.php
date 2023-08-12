<?php

if (!function_exists('ddt')) {
    function ddt(mixed ...$vars): never
    {
        echo "<pre>\n";
        print_r(!empty($vars[1]) ? $vars : $vars[0]);
        exit;
    }
}

