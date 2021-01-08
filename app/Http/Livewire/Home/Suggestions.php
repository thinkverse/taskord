<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;

class Suggestions extends Component
{
    public $readyToLoad = false;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadSuggestions()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $users = User::cacheFor(60 * 60)
            ->select('id', 'username', 'firstname', 'lastname', 'avatar', 'isVerified', 'updated_at')
            ->where([
                ['isFlagged', false],
                ['id', '!=', $this->user->id],
            ])
            ->orderBy('reputation', 'DESC')
            ->take(5)
            ->get();

        return view('livewire.home.suggestions', [
            'users' => $this->readyToLoad ? $users : [],
        ]);
    }
}
