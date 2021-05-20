<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Gamify\Points\CommentCreated;
use App\Models\Comment;
use App\Notifications\Comment\Commented;
use Helper;
use Livewire\Component;

class CreateReply extends Component
{
    public $reply;
    public Comment $comment;

    protected $rules = [
        'reply' => ['required', 'max:20000'],
    ];

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function updated($field)
    {
        if (auth()->check()) {
            $this->validateOnly($field);
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }

            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }

            $reply = auth()->user()->comment_replies()->create([
                'comment_id' =>  $this->comment->id,
                'reply' => $this->reply,
            ]);
            auth()->user()->touch();

            $this->emit('refreshReplies');

            $this->reply = '';

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'success',
                'body' => 'Reply has been added!',
            ]);
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.comment.reply.create-reply');
    }
}
