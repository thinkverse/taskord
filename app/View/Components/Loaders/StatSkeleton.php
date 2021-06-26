<?php

namespace App\View\Components\loaders;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class StatSkeleton extends Component
{
    public function render()
    {
        return view('components.loaders.stat-skeleton');
    }
}
