<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if (auth()->check()) {
            if (auth()->user()->isSuspended) {
                return [
                    'response' => 'Your account is suspended!',
                ];
            }

            return [
                'response' => 'Already logged in',
            ];
        } else {
            $credentials = Arr::only($args, ['email', 'password']);

            if (Auth::once($credentials)) {
                if (auth()->user()->isSuspended) {
                    return [
                        'response' => 'Your account is suspended!',
                    ];
                }

                return [
                    'user' => auth()->user(),
                    'token' => auth()->user()->api_token,
                    'response' => 'Success',
                ];
            } else {
                return [
                    'response' => 'Invalid Credentials',
                ];
            }
        }

        return null;
    }
}
