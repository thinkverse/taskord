<?php

namespace App\View\Components\loaders;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class NotificationSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.loaders.notification-skeleton');
    }
}
