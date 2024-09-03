<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;

class CustomThrottleRequests
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle($request, Closure $next, $maxAttempts = 5, $decayMinutes = 1, $prefix = '')
    {
        $key = $prefix . $this->resolveRequestSignature($request);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'message' => 'Too many attempts. Please try again later.'
            ], 429);
        }

        $this->limiter->hit($key, $decayMinutes);

        return $next($request);
    }

    protected function resolveRequestSignature($request)
    {
        return sha1($request->ip());
    }
}
