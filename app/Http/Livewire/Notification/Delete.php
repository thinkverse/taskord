<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class Delete extends Component
{
    public function deleteAll()
    {
        if (auth()->check()) {
            auth()->user()->notifications()->delete();
            $this->emit('refreshNotifications');
            auth()->user()->touch();
            loggy(request(), 'Notification', auth()->user(), 'Deleted all notifications');

            return Helper::toast($this, 'success', 'All notifications has been deleted!',
            ]);
        } else {
            return Helper::toast($this, 'error', 'Forbidden!',
            ]);
        }
    }
}
