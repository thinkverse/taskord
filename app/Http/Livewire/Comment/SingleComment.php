<?php

namespace App\Http\Livewire\Comment;

use App\Models\Comment;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleComment extends Component
{
    public Comment $comment;
    public $showReplyBox = false;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the comment');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (Gate::allows('praise', $this->comment)) {
            Helper::togglePraise($this->comment, 'COMMENT');

            return loggy(request(), 'Comment', auth()->user(), 'Toggled comment praise | Comment ID: '.$this->comment->id);
        }

        return toast($this, 'error', "Oops! You can't perform this action");
    }

    public function toggleCommentBox()
    {
        $this->showReplyBox = ! $this->showReplyBox;
    }

    public function hide()
    {
        if (Gate::allows('staff_mode')) {
            Helper::hide($this->comment);
            loggy(request(), 'Staff', auth()->user(), 'Toggled hide comment | Comment ID: '.$this->comment->id);

            return toast($this, 'success', 'Comment is hidden from public!');
        }

        return toast($this, 'error', "Oops! You can't perform this action");
    }

    public function deleteComment()
    {
        if (Gate::allows('delete', $this->comment)) {
            loggy(request(), 'Comment', auth()->user(), 'Deleted a comment | Comment ID: '.$this->comment->id);
            $this->comment->delete();
            $this->emit('refreshComments');
            auth()->user()->touch();

            return toast($this, 'success', 'Comment has been deleted successfully!');
        }

        return toast($this, 'error', "Oops! You can't perform this action");
    }
}
