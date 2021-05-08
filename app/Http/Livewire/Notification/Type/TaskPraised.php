<?php

namespace App\Http\Livewire\Notification\Type;

use App\Models\Task;
use Livewire\Component;

class TaskPraised extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $task = Task::find($this->data['task_id']);

        return view('livewire.notification.type.task-praised', [
            'task' => $task,
        ]);
    }
}
