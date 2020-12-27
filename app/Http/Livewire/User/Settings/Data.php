<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Data extends Component
{
    public User $user;
    public $confirming;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function exportAccount()
    {
        if (Auth::check()) {
            $this->confirming = $this->user->id;
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }
}
