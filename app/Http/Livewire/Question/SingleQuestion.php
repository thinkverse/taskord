<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleQuestion extends Component
{
    public Question $question;
    public $type;
    public $confirming;

    public function mount($question, $type)
    {
        $this->question = $question;
        $this->type = $type;
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
                ->log('Rate limited while praising the question');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->question->user->id) {
                return $this->alert('warning', 'You can\'t praise your own question!');
            }
            Helper::togglePraise($this->question, 'QUESTION');
            activity()
                ->withProperties(['type' => 'Question'])
                ->log('Question praise was toggled Q: '.$this->question->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (Auth::user()->isStaff and Auth::user()->staffShip) {
                Helper::hide($this->question);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Question hide was toggled Q: '.$this->question->id);

                return $this->alert('success', 'Question is hidden from public!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->question->id;
    }

    public function deleteQuestion()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->question->user_id) {
                activity()
                    ->withProperties(['type' => 'Question'])
                    ->log('Question was deleted Q: '.$this->question->id);
                $this->question->delete();
                Auth::user()->touch();
                $this->flash('success', 'Question has been deleted successfully!');

                return redirect()->route('questions.newest');
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
