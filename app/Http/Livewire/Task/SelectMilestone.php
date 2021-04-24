<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Milestone;
use App\Models\Task;

class SelectMilestone extends Component
{
    public Task $task;

    public function mount($task)
    {
        $this->task = $task;
    }
    
    public function render()
    {
        return view('livewire.task.select-milestone');
    }
}
