<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleQuestion extends Component
{
    public Question $question;
    public $type;

    public function mount($question, $type)
    {
        $this->question = $question;
        $this->type = $type;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the question');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (auth()->user()->id === $this->question->user->id) {
                return $this->alert('warning', 'You can\'t praise your own question!');
            }
            Helper::togglePraise($this->question, 'QUESTION');
            loggy(request(), 'Question', auth()->user(), 'Toggled question praise | Question ID: '.$this->question->id);
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!'
            ]);
        }
    }

    public function hide()
    {
        if (auth()->check()) {
            if (auth()->user()->isStaff and auth()->user()->staffShip) {
                Helper::hide($this->question);
                loggy(request(), 'Admin', auth()->user(), 'Toggled hide question | Question ID: '.$this->question->id);

                return $this->alert('success', 'Question is hidden from public!');
            } else {
                return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!'
            ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!'
            ]);
        }
    }

    public function deleteQuestion()
    {
        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->question->user_id) {
                loggy(request(), 'Question', auth()->user(), 'Deleted a question | Question ID: '.$this->question->id);
                $this->question->delete();
                auth()->user()->touch();
                $this->flash('success', 'Question has been deleted successfully!');

                return redirect()->route('questions.newest');
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!'
            ]);
        }
    }
}
