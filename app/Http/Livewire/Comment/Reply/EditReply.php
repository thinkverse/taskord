<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\CommentReply;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditReply extends Component
{
    public $reply;
    public $replyId;

    protected $rules = [
        'reply' => ['required', 'min:3', 'max:20000'],
    ];

    public function mount($reply)
    {
        $this->reply = $reply->reply;
        $this->replyId = $reply->id;
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate();
        $comment = Comment::find($this->commentId);
        $comment->comment = $this->comment;
        $comment->save();
        $this->emit('commentEdited');

        loggy(request(), 'Comment', auth()->user(), "Edited a comment | Comment ID: {$this->commentId}");

        return toast($this, 'success', 'Comment has been edited!');
    }

    public function render(): View
    {
        return view('livewire.comment.create-comment');
    }
}
