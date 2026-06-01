<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true) || $user->status_akun !== 'aktif') {
            abort(403, 'Akses tidak diizinkan untuk role ini.');
        }

        return $next($request);
    }
}
