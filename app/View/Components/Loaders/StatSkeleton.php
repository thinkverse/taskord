<?php

namespace App\View\Components\loaders;

use Illuminate\View\View;
use Illuminate\View\Component;

class StatSkeleton extends Component
{
    public function render(): View
    {
        return view('components.loaders.stat-skeleton');
    }
}
