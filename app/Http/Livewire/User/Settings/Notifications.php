<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Helper;
use Livewire\Component;

class Notifications extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function notificationsEmail()
    {
        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->notifications_email = ! $this->user->notifications_email;
                $this->user->save();
                loggy(request(), 'User', auth()->user(), 'Toggled the email notification settings');

                 return toast($this, 'success', 'Notification settings has been updated');
            } else {
                 return toast($this, 'error', 'Forbidden!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function notificationsWeb()
    {
        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->notifications_web = ! $this->user->notifications_web;
                $this->user->save();
                loggy(request(), 'User', auth()->user(), 'Toggled the web notification settings');

                 return toast($this, 'success', 'Notification settings has been updated');
            } else {
                 return toast($this, 'error', 'Forbidden!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
