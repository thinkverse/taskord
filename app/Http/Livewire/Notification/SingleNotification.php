<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class SingleNotification extends Component
{
    public $notificationId;
    public $type;
    public $data;
    public $createdAt;
    public $pageType;

    public function mount($notificationId, $type, $data, $createdAt, $pageType)
    {
        $this->notificationId = $notificationId;
        $this->type = $type;
        $this->pageType = $pageType;
        $this->data = $data;
        $this->createdAt = strval($createdAt);
    }

    public function markSingleNotificationAsRead()
    {
        auth()->user()->unreadNotifications->where('id', $this->notificationId)->markAsRead();
        $this->emit('refreshNotifications');
        loggy(request(), 'Notification', auth()->user(), 'Single notification is marked as read');

        return toast($this, 'success', 'Notification has been marked as read!');
    }
}
