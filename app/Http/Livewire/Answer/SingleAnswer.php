<?php

namespace App\Http\Livewire\Answer;

use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use App\Models\Answer;

class SingleAnswer extends Component
{
    public Answer $answer;
    public $confirming;

    public function mount($answer)
    {
        $this->answer = $answer;
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
                ->log('Rate limited while praising the answer');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->answer->user->id) {
                return $this->alert('warning', 'You can\'t praise your own answer!');
            }
            Helper::togglePraise($this->answer, 'ANSWER');
            activity()
                ->withProperties(['type' => 'Answer'])
                ->log('Answer praise was toggled A: '.$this->answer->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (Auth::user()->isStaff and Auth::user()->staffShip) {
                Helper::hide($this->answer);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Answer hide was toggled A: '.$this->answer->id);

                return $this->alert('success', 'Answer is hidden from public!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->answer->id;
    }

    public function deleteAnswer()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->answer->user->id) {
                activity()
                    ->withProperties(['type' => 'Answer'])
                    ->log('Answer was deleted A: '.$this->answer->id);
                $this->answer->delete();
                $this->emit('answerDeleted');
                Auth::user()->touch();

                return $this->alert('success', 'Answer has been deleted successfully!');
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
