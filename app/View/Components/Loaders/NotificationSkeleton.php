<?php

namespace App\View\Components\loaders;

use Illuminate\View\View;
use Illuminate\View\Component;

class NotificationSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render(): View
    {
        return view('components.loaders.notification-skeleton');
    }
}
