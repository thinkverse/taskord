<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\AuthGetIP;
use App\Models\User;
use App\Notifications\Logger;
use App\Notifications\Welcome;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'alpha_dash', 'string', 'min:2', 'max:20', 'unique:users'],
            'email' => ['required', 'string', 'email', 'indisposable', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'pwned'],
        ],
        [
            'password.pwned' => 'This password has been pwned before',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'avatar' => 'https://avatar.tobi.sh/'.md5($data['email']).'.svg?text='.strtoupper(substr("yoginth", 0, 2)),
            'password' => Hash::make($data['password']),
            'lastIP' => request()->ip(),
            'api_token' => Str::random(60),
        ]);
        AuthGetIP::dispatch($user, request()->ip());
        $user->notify(
            new Logger(
                'AUTH',
                null,
                $user,
                '🎉 New user signed up to Taskord'
            )
        );
        activity()
            ->withProperties(['type' => 'Auth'])
            ->log('New user has been signed up via Taskord auth - @'.$data['username'].' from '.request()->ip());
        $user->notify(new Welcome(true));

        return $user;
    }
}
