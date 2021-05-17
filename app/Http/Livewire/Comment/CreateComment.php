<?php

namespace App\Http\Livewire\Comment;

use App\Gamify\Points\CommentCreated;
use App\Models\Comment;
use App\Models\Task;
use App\Notifications\Comment\Commented;
use Helper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateComment extends Component
{
    public $comment;
    public Task $task;

    protected $rules = [
        'comment' => ['required', 'max:20000'],
    ];

    public function mount($task)
    {
        $this->task = $task;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field);
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $users = Helper::getUsernamesFromMentions($this->comment);

            if ($users) {
                $this->comment = Helper::parseUserMentionsToMarkdownLinks($this->comment, $users);
            }

            $comment = auth()->user()->comments()->create([
                'task_id' =>  $this->task->id,
                'comment' => $this->comment,
            ]);
            auth()->user()->touch();

            $this->emit('commentAdded');
            $this->comment = '';
            Helper::mentionUsers($users, $comment, auth()->user(), 'comment');
            Helper::notifySubscribers($comment->task->subscribers, $comment, 'comment');
            if (! auth()->user()->hasSubscribed($comment->task)) {
                auth()->user()->subscribe($comment->task);
                $this->emit('taskSubscribed');
            }
            if (auth()->user()->id !== $this->task->user->id) {
                $this->task->user->notify(new Commented($comment));
                givePoint(new CommentCreated($comment));
            }
            loggy(request(), 'Comment', auth()->user(), 'Created a new comment | Comment ID: '.$comment->id);

            return $this->alert('success', 'Comment has been added!');
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
