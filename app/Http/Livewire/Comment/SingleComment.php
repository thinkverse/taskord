<?php

namespace App\Http\Livewire\Comment;

use App\Models\Comment;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleComment extends Component
{
    use WithRateLimiting;

    public Comment $comment;
    public $showReplyBox = false;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function togglePraise()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise', $this->comment)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::togglePraise($this->comment, 'COMMENT');

        return loggy(request(), 'Comment', auth()->user(), 'Toggled comment praise | Comment ID: '.$this->comment->id);
    }

    public function toggleCommentBox()
    {
        $this->showReplyBox = ! $this->showReplyBox;
    }

    public function hide()
    {
        if (Gate::denies('staff_mode')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::hide($this->comment);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide comment | Comment ID: '.$this->comment->id);

        return toast($this, 'success', 'Comment is hidden from public!');
    }

    public function deleteComment()
    {
        if (Gate::denies('act', $this->comment)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        loggy(request(), 'Comment', auth()->user(), 'Deleted a comment | Comment ID: '.$this->comment->id);
        $this->comment->delete();
        $this->emit('refreshComments');
        auth()->user()->touch();

        return toast($this, 'success', 'Comment has been deleted successfully!');
    }
}
