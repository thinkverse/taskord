<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateQuestion extends Component
{
    public $title;
    public $body;
    public $patronOnly;

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'title' => 'required|min:5|max:100',
                'body' => 'required|min:3|max:10000',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!', [
                    'showCancelButton' =>  false,
              ]);
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' =>  false,
              ]);
            }

            $patronOnly = ! $this->patronOnly ? false : true;

            $question = Question::create([
                'user_id' =>  Auth::id(),
                'title' => $this->title,
                'body' => $this->body,
                'patronOnly' => $patronOnly,
            ]);
            Auth::user()->touch();

            givePoint(new QuestionCreated($question));
            activity()
                ->withProperties(['type' => 'Question'])
                ->log('New question has been created Q: '.$question->id);
                $this->flash('success', 'Question has been created!', [
                    'showCancelButton' =>  false,
              ]);

            return redirect()->route('question.question', ['id' => $question->id]);
        } else {
            $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
        }
    }
}
