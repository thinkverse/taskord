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
    
    public function selectMilestone()
    {
        dd($this->task);
    }

    public function render()
    {
        $milestones = Milestone::where('user_id', $this->task->user->id)->get();
        return view('livewire.task.select-milestone', [
            'milestones' => $milestones
        ]);
    }
}
