<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsStaffShip
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
        if ($request->user() && $request->user()->staffShip) {
            return $next($request);
        } else {
            return abort(404);
        }
    }
}
