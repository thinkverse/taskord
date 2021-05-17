<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MarkAsRead extends Component
{
    public function markAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
            $this->emit('markAsRead');
            auth()->user()->touch();
            loggy(request(), 'Notification', auth()->user(), 'All notifications are marked as read');

            return $this->alert('success', 'Notifications has been marked as read!');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
