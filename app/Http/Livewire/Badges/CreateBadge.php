<?php

namespace App\Http\Livewire\Badges;

use Livewire\Component;

class CreateBadge extends Component
{
    public $title;
    public $icon;

    public function render()
    {
        return view('livewire.badges.create-badge');
    }
}
