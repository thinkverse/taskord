<?php

namespace App\View\Components\Shared;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Toast extends Component
{
    public function render()
    {
        return view('components.shared.toast');
    }
}
