<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public $listeners = [
        'questionSubscribed' => 'render',
    ];

    public Question $question;

    public function mount($question)
    {
        $this->question = $question;
    }

    public function subscribeQuestion()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while subscribing to the question');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }
            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->question->user->id) {
                return $this->alert('warning', 'You can\'t subscribe your own question!');
            } else {
                user()->toggleSubscribe($this->question);
                $this->question->refresh();
                user()->touch();
                activity()
                    ->withProperties(['type' => 'Question'])
                    ->log('Toggled question subscribe | Question ID: '.$this->question->id);
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.question.subscribe');
    }
}
