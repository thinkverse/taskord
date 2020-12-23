<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class Status extends Component
{
    public $listeners = [
        'statusUpdated'  => 'render',
    ];

    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function clearStatus()
    {
        if (Auth::check()) {
            Auth::user()->status = null;
            Auth::user()->status_emoji = null;
            Auth::user()->save();
            $this->emit('statusUpdated');
            activity()
                ->withProperties(['type' => 'User'])
                ->log('User status was cleared');

            return $this->alert('success', 'Status cleared successfully!');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function submit($event)
    {
        if (Auth::check()) {
            if (strlen($event['status_emoji']) === 0) {
                return $this->alert('warning', 'Select the emoji!');
            }

            if (strlen($event['status']) !== 0) {
                Auth::user()->status = $event['status'];
                Auth::user()->status_emoji = $event['status_emoji'];
                Auth::user()->save();
                $this->emit('statusUpdated');
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('User status was updated');

                return $this->alert('success', 'Status set successfully!');
            } else {
                Auth::user()->status = null;
                Auth::user()->status_emoji = null;
                Auth::user()->save();
                $this->emit('statusUpdated');
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('User status was cleared');

                return $this->alert('success', 'Status cleared successfully!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
