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
        $total = $this->milestone->tasks()->count();
        if ($total != 0) {
            $percent = number_format($completed/$total * 100, 0);
        } else {
            $percent = 0;
        }

        return view('livewire.milestone.progress', [
            'completed' => $completed,
            'pending' => $pending,
            'percent' => $percent,
        ]);
    }
}
