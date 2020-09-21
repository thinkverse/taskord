<?php

namespace App\Http\Livewire\Answer;

use App\Gamify\Points\CommentCreated;
use App\Models\Answer;
use App\Notifications\Answered;
use App\Notifications\TelegramLogger;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Helper;

class CreateAnswer extends Component
{
    public $answer;
    public $question;

    public function mount($question)
    {
        $this->question = $question;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'answer' => 'required',
            ]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'answer' => 'required',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            
            $users = Helper::getUserIDFromMention($this->answer);

            $answer = Answer::create([
                'user_id' =>  Auth::id(),
                'question_id' =>  $this->question->id,
                'answer' => $this->answer,
            ]);
            Auth::user()->touch();

            $this->emit('answerAdded');
            $this->answer = '';
            Helper::mentionUsers($users, $answer, 'answer');
            if (Auth::id() !== $this->question->user->id) {
                $this->question->user->notify(new Answered($answer));
                givePoint(new CommentCreated($answer));
            }

            $this->question->user->notify(
                new TelegramLogger(
                    '*💬 New answer was added* by @'
                    .Auth::user()->username."\n\n"
                    .$answer->answer."\n\nhttps://taskord.com/question/"
                    .$this->question->id
                )
            );

            return session()->flash('success', 'Answer has been added!');
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.answer.create-answer');
    }
}
