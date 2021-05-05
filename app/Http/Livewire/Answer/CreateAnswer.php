<?php

namespace App\Http\Livewire\Answer;

use App\Gamify\Points\CommentCreated;
use App\Models\Answer;
use App\Models\Question;
use App\Notifications\Answered;
use Helper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateAnswer extends Component
{
    public $answer;
    public Question $question;

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
            $this->alert('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'answer' => 'required',
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $users = Helper::getUsernamesFromMentions($this->answer);

            if ($users) {
                $this->answer = Helper::parseUserMentionsToMarkdownLinks($this->answer, $users);
            }

            $answer = Answer::create([
                'user_id' =>  auth()->user()->id,
                'question_id' =>  $this->question->id,
                'answer' => $this->answer,
            ]);
            auth()->user()->touch();

            $this->emit('answerAdded');
            $this->answer = '';
            Helper::mentionUsers($users, $answer, auth()->user(), 'answer');
            Helper::notifySubscribers($answer->question->subscribers, $answer, 'answer');
            if (! auth()->user()->hasSubscribed($answer->question)) {
                auth()->user()->subscribe($answer->question);
                $this->emit('questionSubscribed');
            }
            if (auth()->user()->id !== $this->question->user->id) {
                $this->question->user->notify(new Answered($answer));
                givePoint(new CommentCreated($answer));
            }
            loggy(request(), 'Answer', auth()->user(), 'Created a new answer | Answer ID: '.$answer->id);

            return $this->alert('success', 'Answer has been added!');
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.answer.create-answer');
    }
}
