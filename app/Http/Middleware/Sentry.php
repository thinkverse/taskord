<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use function Sentry\configureScope;
use Sentry\State\Scope;

class Sentry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
