<?php

namespace App\Http\Controllers;

use App\Jobs\AuthGetIP;
use App\Models\User;
use App\Notifications\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        $providerArray = ['twitter', 'google', 'github', 'discord'];
        if (in_array($provider, $providerArray)) {
            return Socialite::driver($provider)->redirect();
        }

        return abort(404);
    }

    public function Callback(Request $request, $provider)
    {
        if ($provider === 'twitter') {
            $userSocial = Socialite::driver($provider)->user();
        } else {
            $userSocial = Socialite::driver($provider)->stateless()->user();
        }

        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if ($user) {
            Auth::login($user);
            AuthGetIP::dispatch($user, $request->ip());
            loggy(request(), 'Auth', $user, 'Logged in via Social auth');

            return redirect()->route('home');
        }

        if ($provider === 'twitter' or $provider === 'github') {
            $user = User::where(['username' => $userSocial->getNickname()])->first();
            if (! $user) {
                $username = $userSocial->getNickname();
            } else {
                $username = $userSocial->getNickname().'_'.strtolower(Str::random(5));
            }
        } else {
            $username = strtolower(Str::random(6));
        }

        if ($provider === 'github' or $provider === 'discord') {
            $avatar = $userSocial->avatar;
        } else {
            $avatar = str_replace('http://', 'https://', $userSocial->avatar_original);
        }

        $user = User::create([
            'username'          => $username,
            'firstname'         => $userSocial->getName(),
            'email'             => $userSocial->getEmail(),
            'avatar'            => $avatar,
            'provider_id'       => $userSocial->getId(),
            'provider'          => $provider,
            'api_token'         => Str::random(60),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        AuthGetIP::dispatch($user, $request->ip());

        if ($provider === 'twitter') {
            $user->twitter = $userSocial->getNickname();
            $user->save();
        }

        if ($provider === 'github') {
            $user->github = $userSocial->getNickname();
            $user->save();
        }

        Auth::login($user);
        $user->notify(new Welcome(true));
        loggy(
            request()->ip(),
            'Auth',
            $user,
            'Created account with '.$provider.' '.$user->email.' from '.request()->ip()
        );

        return redirect()->route('home');
    }
}
