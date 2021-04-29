<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Livewire\Component;

class SingleFeature extends Component
{
    public Feature $feature;

    public function mount($feature)
    {
        $this->feature = $feature;
    }

    public function render()
    {
        return view('livewire.admin.features.single-feature');
    }
}
