<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use function Sentry\configureScope;
use Sentry\State\Scope;

class SentryContext
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
        if (app()->bound('sentry')) {
            if (auth()->check()) {
                configureScope(function (Scope $scope): void {
                    $user = auth()->user();
                    $scope->setUser([
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                    ]);
                    $scope->setTag('page.route.name', Route::currentRouteName() ?? '');
                    $scope->setTag('page.route.action', Route::currentRouteAction() ?? '');
                });
            }
        }

        return $next($request);
    }
}
