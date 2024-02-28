<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountAuthorization
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = $request->user('admin'); 

        if ($currentUser !== null && $currentUser->admin_level == 1) {
            return $next($request); 
        }

        abort(403, '権限が無いためこの操作を実行できません。前のページに戻ってください。');
    }
}
