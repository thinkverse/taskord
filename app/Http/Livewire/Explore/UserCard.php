<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;

class UserCard extends Component
{
    public $readyToLoad = false;

    public function loadUser()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $user = auth()->user();

        return view('livewire.explore.user-card', [
            'user' => $this->readyToLoad ? $user : [],
        ]);
    }
}
