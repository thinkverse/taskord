<?php

namespace App\View\Components\Loaders;

use Illuminate\View\Component;

class UserSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.loaders.user-skeleton');
    }
}
