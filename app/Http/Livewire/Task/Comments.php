<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Task;
use App\Models\Comment;

class Comments extends Component
{
    public $task;
    public $readyToLoad = false;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function loadComments()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $comments = $this->task->comments->take(5);
        return view('livewire.task.comments', [
            'comments' => $comments
        ]);
    }
}
