<?php

namespace App\View\Components\Loaders;

use Illuminate\View\Component;
use Illuminate\View\View;

class TaskSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render(): View
    {
        return view('components.loaders.task-skeleton');
    }
}
