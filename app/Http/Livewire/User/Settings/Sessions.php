<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

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
            ->get();

        // dd($sessions);

        return view('livewire.user.settings.sessions', [
            'sessions' => $sessions,
        ]);
    }
}
