<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use Livewire\Component;

class CreateQuestion extends Component
{
    public $title;
    public $body;
    public $solvable = true;
    public $patron_only;

    public function submit()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validate([
            'title' => ['required', 'min:3', 'max:150'],
            'body' => ['required', 'min:3', 'max:20000'],
        ]);

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        $solvable = ! $this->solvable ? false : true;
        $patron_only = ! $this->patron_only ? false : true;

        $question = auth()->user()->questions()->create([
            'title' => $this->title,
            'body' => $this->body, 
            'is_solvable' => $solvable,
            'patron_only' => $patron_only,
        ]);
        auth()->user()->touch();

        givePoint(new QuestionCreated($question));
        loggy(request(), 'Question', auth()->user(), 'Created a new question | Question ID: '.$question->id);

        return redirect()->route('question.question', ['id' => $question->id]);
    }
}
