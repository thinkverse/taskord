<?php

namespace App\View\Components\loaders;

use Illuminate\View\Component;

class ReplySkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.loaders.reply-skeleton');
    }
}
