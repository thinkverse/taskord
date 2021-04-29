<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Livewire\Component;

class SingleFeature extends Component
{
    public Feature $feature;
    public $status;

    public function mount($feature)
    {
        $this->feature = $feature;
        $this->status = $feature->enabled;
    }

    public function toggleFeature()
    {
        $this->feature->enabled = $this->status;
        $this->feature->save();
    }

    public function render()
    {
        return view('livewire.admin.features.single-feature');
    }
}
