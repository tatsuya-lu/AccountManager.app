<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated',
            $guards,
            $this->redirectToOriginal($request,$guards)
        );
    }

    protected function redirectToOriginal($request, array $guards)
    {
        foreach ($guards as $guards) {
            if ($guards === 'admin') {
                return route('login');
            }
        }
    }
}
