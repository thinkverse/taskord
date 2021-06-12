<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class Appearance extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function toggleMode($mode)
    {
        if (auth()->user()->id === $this->user->id) {
            Cookie::queue('color_mode', $mode, config('session.lifetime'));
            $this->emit('toggledMode');

            return loggy(request(), 'User', auth()->user(), 'Toggled appearance');
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }
}
