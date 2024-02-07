<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->route('user');

        // $userがnullでないことを確認する
        if ($user !== null && ($request->user('admin')->admin_level == 1 || $request->user('admin')->id === $user->id)) {
            return $next($request);
        }

        abort(403, '権限が無いためこの操作を実行できません。');
    }
}
