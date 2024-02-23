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
        $currentUser = $request->user('admin'); // 現在のログインユーザーを取得します。

        // 現在のユーザーが存在し、かつ管理者であるかどうかを確認します。
        if ($currentUser !== null && $currentUser->admin_level == 1) {
            return $next($request); // 管理者の場合は次の処理に進みます。
        }

        abort(403, '権限が無いためこの操作を実行できません。');
    }
}
