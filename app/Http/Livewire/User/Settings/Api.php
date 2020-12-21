<?php

namespace App\Http\Livewire\User\Settings;

use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Livewire\Component;

class Api extends Component
{
    public $user;

    public $listeners = [
        'tokenRegenerated' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function regenerateToken()
    {
        $throttler = Throttle::get(Request::instance(), 5, 5);
        $throttler->hit();
        if (count($throttler) > 10) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while generating a token');

            return $this->alert('warning', 'Your are rate limited, try again later!', [
                'showCancelButton' => true,
            ]);
        }

        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                Auth::user()->api_token = Str::random(60);
                Auth::user()->save();
                $this->emit('tokenRegenerated');
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('New API key was generated');
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.settings.api');
    }
}
