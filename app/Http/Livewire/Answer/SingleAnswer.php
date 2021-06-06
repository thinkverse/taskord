<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleAnswer extends Component
{
    use WithRateLimiting;

    public Answer $answer;

    public function mount($answer)
    {
        $this->answer = $answer;
    }

    public function toggleLike()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->answer)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::toggleLike($this->answer, 'ANSWER');
        $this->emit('answerLiked');

        return loggy(request(), 'Answer', auth()->user(), "Toggled answer like | Answer ID: {$this->answer->id}");
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::hide($this->answer);
        loggy(request(), 'Staff', auth()->user(), "Toggled hide answer | Answer ID: {$this->answer->id}");

        return toast($this, 'success', 'Answer is hidden from public!');
    }

    public function deleteAnswer()
    {
        if (Gate::denies('edit/delete', $this->answer)) {
            return toast($this, 'success', 'Answer has been deleted successfully!');
        }

        loggy(request(), 'Answer', auth()->user(), "Deleted an answer | Answer ID: {$this->answer->id}");
        $this->answer->delete();
        $this->emit('refreshAnswers');

        return auth()->user()->touch();
    }
}
