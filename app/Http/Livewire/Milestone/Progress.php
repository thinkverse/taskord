<?php

namespace App\Http\Livewire\Milestone;

use Livewire\Component;
use App\Models\Milestone;
use App\Models\Task;

class Progress extends Component
{
    public Milestone $milestone;

    public function mount($milestone)
    {
        $this->milestone = $milestone;
    }

    public function render()
    {
        $completed = $this->milestone->tasks()->where('done', true)->count();
        $pending = $this->milestone->tasks()->where('done', false)->count();

        return view('livewire.milestone.progress', [
            'completed' => $completed,
            'pending' => $pending,
        ]);
    }
}
