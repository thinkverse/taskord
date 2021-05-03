<?php

namespace App\Http\Livewire\Task;

use App\Models\Milestone;
use App\Models\Task;
use Livewire\Component;

class SelectMilestone extends Component
{
    public Task $task;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function noMilestone()
    {
        $this->task->milestone()->disassociate();
        $this->task->save();
        $this->emitUp('addedToMilestone');
        loggy(request()->ip(), 'Milestone', auth()->user(), 'Removed milestone from the task | Task ID: '.$this->task->id);

        return $this->alert('success', 'Milestone has been removed from the task!');
    }

    public function selectMilestone(Milestone $milestone)
    {
        $milestone = Milestone::find($milestone->id);
        $this->task->milestone()->associate($milestone);
        $this->task->save();
        $this->emitUp('addedToMilestone');
        loggy(request()->ip(), 'Milestone', auth()->user(), 'Added milestone to the task | Task ID: '.$this->task->id);

        return $this->alert('success', 'Task has been added to the milestone #'.$milestone->id);
    }

    public function render()
    {
        $milestones = $this->task->user->milestones()
            ->where('user_id', $this->task->user->id)
            ->latest()
            ->get();

        return view('livewire.task.select-milestone', [
            'milestones' => $milestones,
        ]);
    }
}
