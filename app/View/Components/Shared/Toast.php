<?php

namespace App\View\Components\Shared;

use Illuminate\View\Component;
use Illuminate\View\View;

class Toast extends Component
{
    public function render(): View
    {
        return view('components.shared.toast');
    }
}
