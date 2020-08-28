<?php

namespace App\Http\Livewire\User;

use App\Models\Answer;
use Livewire\Component;

class Answers extends Component
{
    public $user_id;

    public function mount($user)
    {
        $this->user_id = $user->id;
    }

    public function render()
    {
        $answers = Answer::where('user_id', $this->user_id)
            ->latest()
            ->paginate(20);

        return view('livewire.user.answers', [
            'answers' => $answers,
        ]);
    }
}
