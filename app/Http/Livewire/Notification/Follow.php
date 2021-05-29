<?php

namespace App\Http\Livewire\Notification;

use App\Models\User;
use App\Notifications\Followed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Follow extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function toggleFollow()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while following the user');

            return toast($this, 'error', 'Your are rate limited, try again later!');
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
        auth()->user()->touch();
        if (auth()->user()->isFollowing($this->user)) {
            $this->user->notify(new Followed(auth()->user()));
        }

        return loggy(request(), 'Notification', auth()->user(), 'Toggled user follow | Username: @'.$this->user->username);
    }
}
