<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use App\Models\User;

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
        $users  = User::cacheFor(60 * 60)
            ->select('id', 'username', 'firstname', 'lastname', 'avatar', 'reputation', 'isVerified')
            ->where([
                ['isFlagged', false],
                ['id', '!=', 1],
            ])
            ->orderBy('reputation', 'DESC')
            ->take(10)
            ->get();
            
        return view('livewire.home.suggestions', [
            'users' => $this->readyToLoad ? $users : [],
        ]);
    }
}
