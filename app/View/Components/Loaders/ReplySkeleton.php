<?php

namespace App\View\Components\loaders;

use Illuminate\View\Component;
use Illuminate\View\View;

class ReplySkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render(): View
    {
        return view('components.loaders.reply-skeleton');
    }
}
