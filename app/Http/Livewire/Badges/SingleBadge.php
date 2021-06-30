<?php

namespace App\Http\Livewire\Badges;

use Livewire\Component;
use Illuminate\View\View;

class SingleBadge extends Component
{
    public function render(): View
    {
        return view('livewire.badges.single-badge');
    }
}
