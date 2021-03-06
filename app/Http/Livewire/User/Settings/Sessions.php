<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class Sessions extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render(): View
    {
        $sessions = DB::table('sessions')
            ->whereUserId($this->user->id)
            ->latest('last_activity')
            ->limit(30)
            ->get();

        return view('livewire.user.settings.sessions', [
            'sessions' => $sessions,
        ]);
    }
}
