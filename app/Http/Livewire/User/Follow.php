<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\Followed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Follow extends Component
{
    use WithRateLimiting;
    
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function toggleFollow()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }
        if (auth()->user()->id === $this->user->id) {
            return toast($this, 'error', 'You can\'t follow yourself!');
        }

        auth()->user()->toggleFollow($this->user);
        $this->user->refresh();
        auth()->user()->touch();
        if (auth()->user()->isFollowing($this->user)) {
            $this->user->notify(new Followed(auth()->user()));
        }

        return loggy(request(), 'User', auth()->user(), 'Toggled user follow | Username: @'.$this->user->username);
    }
}
