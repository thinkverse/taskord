<?php

namespace App\Http\Livewire\Comment;

use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleComment extends Component
{
    public $comment;
    public $confirming;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while praising the comment');

            return $this->alert('error', 'Your are rate limited, try again later!', [
                'showCancelButton' => true,
            ]);
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!', [
                    'showCancelButton' => true,
                ]);
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }
            if (Auth::id() === $this->comment->user->id) {
                return $this->alert('warning', 'You can\'t praise your own comment!', [
                    'showCancelButton' => true,
                ]);
            }
            Helper::togglePraise($this->comment, 'COMMENT');
            activity()
                ->withProperties(['type' => 'Comment'])
                ->log('Comment praise was toggled C: '.$this->comment->id);
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (Auth::user()->isStaff and Auth::user()->staffShip) {
                Helper::hide($this->comment);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Comment hide was toggled C: '.$this->comment->id);

                return $this->alert('success', 'Comment is hidden from public!', [
                    'showCancelButton' => true,
                ]);
            } else {
                return $this->alert('error', 'Forbidden!', [
                    'showCancelButton' => true,
                ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->comment->id;
    }

    public function deleteComment()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }
            if (Auth::user()->staffShip or Auth::id() === $this->comment->user->id) {
                activity()
                    ->withProperties(['type' => 'Comment'])
                    ->log('Comment was deleted C: '.$this->comment->id);
                $this->comment->delete();
                $this->emit('commentDeleted');
                Auth::user()->touch();

                return $this->alert('success', 'Comment has been deleted successfully!', [
                    'showCancelButton' => true,
                ]);
            } else {
                return $this->alert('error', 'Forbidden!', [
                    'showCancelButton' => true,
                ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.comment.single-comment');
    }
}
