<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;

class RecentlyJoined extends Component
{
    public $readyToLoad = false;

    public function loadRecentlyJoined()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $recently_joined = User::select('id', 'username', 'firstname', 'lastname', 'avatar', 'bio', 'isVerified', 'status', 'status_emoji', 'created_at')
            ->where([
                ['isFlagged', false],
            ])
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        return view('livewire.home.recently-joined', [
            'recently_joined' => $this->readyToLoad ? $recently_joined : [],
        ]);
    }
}
