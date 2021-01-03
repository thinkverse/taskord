<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class SingleNotification extends Component
{
    public $type;
    public $data;
    public $created_at;
    public $page_type;

    public function mount($type, $data, $created_at, $page_type)
    {
        $this->type = $type;
        $this->page_type = $page_type;
        $this->data = $data;
        $this->created_at = strval($created_at);
    }
}
