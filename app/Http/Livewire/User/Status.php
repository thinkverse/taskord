<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Status extends Component
{
    public $listeners = [
        'statusUpdated'  => 'render'
    ];

    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function submit($event)
    {
        if (Auth::check()) {
            if (strlen($event['status_emoji']) === 0) {
                return session()->flash('warning', 'Select the emoji!');
            }

            if (strlen($event['status']) !== 0) {
                Auth::user()->status = $event['status'];
                Auth::user()->status_emoji = $event['status_emoji'];
                Auth::user()->save();
                $this->emit('statusUpdated');
                return session()->flash('success', 'Status set successfully!');
            } else {
                Auth::user()->status = null;
                Auth::user()->status_emoji = null;
                Auth::user()->save();
                $this->emit('statusUpdated');
                return session()->flash('success', 'Status cleared successfully!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.status');
    }
}
