<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\CommentReply;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleReply extends Component
{
    public CommentReply $reply;

    public function mount($reply)
    {
        $this->reply = $reply;
    }

    public function deleteReply()
    {
        if (! auth()->check()) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->reply->user->id) {
            loggy(request(), 'Reply', auth()->user(), 'Deleted a reply | Reply ID: '.$this->reply->id);
            $this->reply->delete();
            $this->emit('refreshReplies');
            auth()->user()->touch();

            return toast($this, 'success', 'Reply has been deleted successfully!');
        }

        return toast($this, 'error', "Oops! You can't perform this action");
    }

    public function hide()
    {
        if (Gate::allows('staff_mode')) {
            Helper::hide($this->reply);
            loggy(request(), 'Staff', auth()->user(), 'Toggled hide reply | Reply ID: '.$this->reply->id);

            return toast($this, 'success', 'Reply is hidden from public!');
        }

        return toast($this, 'error', "Oops! You can't perform this action");
    }
}
