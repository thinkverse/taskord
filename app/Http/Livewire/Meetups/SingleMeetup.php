<?php

namespace App\Http\Livewire\Meetups;

use App\Models\Meetup;
use Livewire\Component;

class SingleMeetup extends Component
{
    public Meetup $meetup;

    public function mount($meetup)
    {
        $this->meetup = $meetup;
    }

    public function toggleRSVP()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->meetup)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        auth()->user()->toggleSubscribe($this->meetup);

        return $this->meetup->refresh();
    }
}
