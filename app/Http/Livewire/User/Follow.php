<?php

namespace App\Http\Livewire\User;

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

    public function followUser()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while following the user');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (auth()->user()->id === $this->user->id) {
                return $this->alert('warning', 'You can\'t follow yourself!');
            } else {
                auth()->user()->toggleFollow($this->user);
                $this->user->refresh();
                auth()->user()->touch();
                if (auth()->user()->isFollowing($this->user)) {
                    $this->user->notify(new Followed(auth()->user()));
                }
                loggy(request(), 'User', auth()->user(), 'Toggled user follow | Username: @'.$this->user->username);
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
