<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use App\Notifications\Followed;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class Follow extends Component
{
    use WithRateLimiting;

    public User $user;
    public $showText;

    public function mount($user, $showText)
    {
        $this->showText = $showText;
        $this->user = $user;
    }

    public function toggleFollow()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise', $this)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        auth()->user()->toggleFollow($this->user);
        auth()->user()->touch();
        if (auth()->user()->isFollowing($this->user)) {
            $this->user->notify(new Followed(auth()->user()));
        }
        loggy(request(), 'Notification', auth()->user(), 'Toggled user follow | Username: @'.$this->user->username);
        $this->emitUp('refreshSuggestions');

        return toast($this, 'success', 'Followed successfully!');
    }
}
