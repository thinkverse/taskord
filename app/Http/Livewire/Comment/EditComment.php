<?php

namespace App\Http\Livewire\Comment;

use App\Gamify\Points\CommentCreated;
use App\Models\Task;
use App\Notifications\Comment\Commented;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditComment extends Component
{
    public $comment = '';
    public Task $task;

    protected $rules = [
        'comment' => ['required', 'min:3', 'max:20000'],
        'task' => ['required'],
    ];

    public function mount($task)
    {
        $this->task = $task;
    }

    public function updated($field)
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validateOnly($field);
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate();

        $comment = auth()->user()->comments()->create([
            'task_id' => $this->task->id,
            'comment' => $this->comment,
        ]);
        $this->emit('refreshComments');
        $this->reset('comment');

        loggy(request(), 'Comment', auth()->user(), "Edited a comment | Comment ID: {$comment->id}");

        return toast($this, 'success', 'Comment has been edited!');
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
