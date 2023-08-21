<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LoggedUserSession
{
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check()) {
            $user = auth()->user();

            Session::put([
                'user' => [
                    'teste' => '123'
                ]
            ]);
        }

        return $next($request);
    }
}
