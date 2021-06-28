<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserActivity extends Component
{
    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function render(): View
    {
        return view('components.user-activity');
    }
}
