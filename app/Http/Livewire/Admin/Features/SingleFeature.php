<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Livewire\Component;

class SingleFeature extends Component
{
    public Feature $feature;
    public $enabled;

    public function mount($feature)
    {
        $this->feature = $feature;
        $this->enabled = $feature->enabled;
    }

    public function toggleFeature()
    {
        $this->feature->enabled = $this->enabled;
        $this->feature->save();
    }

    public function render()
    {
        return view('livewire.admin.features.single-feature');
    }
}
