<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sessions extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $sessions = DB::table('sessions')
            ->whereUserId($this->user->id)
            ->latest('last_activity')
            ->get();

        return view('livewire.user.settings.sessions', [
            'sessions' => $sessions,
        ]);
    }
}
