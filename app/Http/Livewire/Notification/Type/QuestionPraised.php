<?php

namespace App\Http\Livewire\Notification\Type;

use App\Models\Question;
use Livewire\Component;

class QuestionPraised extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $question = Question::find($this->data['question_id']);

        return view('livewire.notification.type.question-praised', [
            'question' => $question,
        ]);
    }
}
