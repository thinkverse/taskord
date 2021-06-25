<?php

namespace App\Http\Livewire\Comment;

use App\Gamify\Points\CommentCreated;
use App\Models\Task;
use App\Models\Comment;
use App\Notifications\Comment\Commented;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditComment extends Component
{
    public $comment;
    public $commentId;

    protected $rules = [
        'comment' => ['required', 'min:3', 'max:20000'],
    ];

    public function mount($comment)
    {
        $this->comment = $comment->comment;
        $this->commentId = $comment->id;
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
        Comment::whereId($this->commentId)
            ->update(["comment" => $this->comment]);

        $this->emit('refreshComments');
        $this->reset();

        loggy(request(), 'Comment', auth()->user(), "Edited a comment | Comment ID: {$this->commentId}");

        return toast($this, 'success', 'Comment has been edited!');
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
