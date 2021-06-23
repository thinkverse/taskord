<?php

namespace App\View\Components\loaders;

use Illuminate\View\Component;

class MilestoneSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.loaders.milestone-skeleton');
    }
}
