<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleAnswer extends Component
{
    public Answer $answer;

    public function mount($answer)
    {
        $this->answer = $answer;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the answer');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }
            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (auth()->user()->id === $this->answer->user->id) {
                return $this->alert('warning', 'You can\'t praise your own answer!');
            }
            Helper::togglePraise($this->answer, 'ANSWER');
            loggy(request(), 'Answer', auth()->user(), 'Toggled answer praise | Answer ID: '.$this->answer->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (auth()->check()) {
            if (auth()->user()->isStaff and auth()->user()->staffShip) {
                Helper::hide($this->answer);
                loggy(request(), 'Admin', auth()->user(), 'Toggled hide answer | Answer ID: '.$this->answer->id);

                return $this->alert('success', 'Answer is hidden from public!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function deleteAnswer()
    {
        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->answer->user->id) {
                loggy(request(), 'Answer', auth()->user(), 'Deleted an answer | Answer ID: '.$this->answer->id);
                $this->answer->delete();
                $this->emit('answerDeleted');
                auth()->user()->touch();

                return $this->alert('success', 'Answer has been deleted successfully!');
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
