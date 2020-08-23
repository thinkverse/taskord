<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Delete extends Component
{
    public $user;
    public $confirming;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function confirmDelete()
    {
        if (Auth::check()) {
            $this->confirming = $this->user->id;
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function deleteAccount()
    {
        if (Auth::check()) {
            $user = User::find($this->user->id);
            $user->likes()->delete();
            $user->delete();

            return redirect()->route('home');
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.delete');
    }
}
