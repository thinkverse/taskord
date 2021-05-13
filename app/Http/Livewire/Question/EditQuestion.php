<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditQuestion extends Component
{
    public Question $question;
    public $title;
    public $body;
    public $patronOnly;

    protected $rules = [
        'title' => ['required', 'min:5', 'max:150'],
        'body' => ['required', 'min:3', 'max:20000'],
    ];

    public function mount($question)
    {
        $this->question = $question;
        $this->title = $question->title;
        $this->body = $question->body;
        $this->patronOnly = $question->patronOnly;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field);
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $question = Question::where('id', $this->question->id)->firstOrFail();

            $patronOnly = ! $this->patronOnly ? false : true;

            if (auth()->user()->staffShip or auth()->user()->id === $question->user_id) {
                $question->title = $this->title;
                $question->body = $this->body;
                $question->patronOnly = $this->patronOnly;
                $question->save();
                auth()->user()->touch();

                loggy(request(), 'Question', auth()->user(), 'Updated a question | Question ID: '.$question->id);
                $this->flash('success', 'Question has been edited!');

                return redirect()->route('question.question', ['id' => $question->id]);
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }
}
