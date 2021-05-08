<?php

namespace App\Http\Livewire\Notification\Type\Question;

use App\Models\Answer;
use Livewire\Component;

class NotifySubscribers extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $answer = Answer::find($this->data['answer_id']);

        return view('livewire.notification.type.question.notify-subscribers', [
            'answer' => $answer,
        ]);
    }
}
