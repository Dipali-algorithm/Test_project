<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpsFoundation\Response;

class clientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('client')->check()) {
            return $next($request);
        }

        return redirect()->route('client.login'); // or any other redirect logic
    }
}
