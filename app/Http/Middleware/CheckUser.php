<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        app('debugbar')->disable();
        if (auth()->check()) {
            $request->user()->last_active = carbon();
            $request->user()->save();

            if (auth()->user()->staff_mode) {
                app('debugbar')->enable();
            }

            if ($request->user()->is_suspended) {
                auth()->logout();

                return redirect()->route('suspended');
            }
        }

        return $next($request);
    }
}
