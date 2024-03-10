<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckTokenExpiration
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->token()->expires_at->isPast()) {
            // Token is expired, revoke it
            Auth::user()->token()->revoke();
        }

        return $next($request);
    }
}
