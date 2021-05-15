<?php

namespace App\Http\Livewire\Shared;

use Livewire\Component;

class User extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.shared.user');
    }
}
