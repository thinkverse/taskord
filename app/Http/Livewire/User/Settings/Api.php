<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Api extends Component
{
    use WithRateLimiting;
    
    public User $user;

    public $listeners = [
        'refreshApiToken' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function regenerateToken()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (auth()->user()->id === $this->user->id) {
            auth()->user()->api_token = Str::random(60);
            auth()->user()->save();
            $this->emit('refreshApiToken');
            loggy(request(), 'User', auth()->user(), 'Created a new API key');

            return toast($this, 'success', 'New API key been generated successfully');
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }

    public function render()
    {
        return view('livewire.user.settings.api');
    }
}
