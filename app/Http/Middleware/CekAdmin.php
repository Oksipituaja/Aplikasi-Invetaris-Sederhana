<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CekAdmin
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Akses hanya untuk admin.');
    }
}