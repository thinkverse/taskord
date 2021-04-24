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
    
    public function selectMilestone(Milestone $milestone)
    {
        $milestone = Milestone::find($milestone->id);
        $this->task->milestone()->associate($milestone);
        $this->task->save();
        $this->emitUp('addedToMilestone');
        return $this->alert('success', 'Task has been added to the milestone #' . $milestone->id);
    }

    public function render()
    {
        $milestones = Milestone::where([
                ['user_id', $this->task->user->id],
                ['status', true],
            ])
            ->latest()
            ->get();
        return view('livewire.task.select-milestone', [
            'milestones' => $milestones
        ]);
    }
}
