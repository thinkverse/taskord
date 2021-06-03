<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\CommentReply;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleReply extends Component
{
    use WithRateLimiting;

    public CommentReply $reply;

    public function mount($reply)
    {
        $this->reply = $reply;
    }

    public function togglePraise()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->reply)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::togglePraise($this->reply, 'REPLY');

        return loggy(request(), 'Reply', auth()->user(), 'Toggled reply like | Reply ID: '.$this->reply->id);
    }

    public function deleteReply()
    {
        if (Gate::denies('edit/delete', $this->reply)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        loggy(request(), 'Reply', auth()->user(), 'Deleted a reply | Reply ID: '.$this->reply->id);
        $this->reply->delete();
        $this->emit('refreshReplies');
        auth()->user()->touch();

        return toast($this, 'success', 'Reply has been deleted successfully!');
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::hide($this->reply);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide reply | Reply ID: '.$this->reply->id);

        return toast($this, 'success', 'Reply is hidden from public!');
    }
}
