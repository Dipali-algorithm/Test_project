<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureClientIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login');
        }

        return $next($request);
    }
}
