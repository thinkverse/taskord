<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class SingleAnswer extends Component
{
    use WithRateLimiting;
    
    public Answer $answer;

    public function mount($answer)
    {
        $this->answer = $answer;
    }

    public function togglePraise()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise', $this->answer)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::togglePraise($this->answer, 'ANSWER');

        return loggy(request(), 'Answer', auth()->user(), 'Toggled answer praise | Answer ID: '.$this->answer->id);
    }

    public function hide()
    {
        if (Gate::denies('staff_mode')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::hide($this->answer);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide answer | Answer ID: '.$this->answer->id);

        return toast($this, 'success', 'Answer is hidden from public!');
    }

    public function deleteAnswer()
    {
        if (Gate::denies('act', $this->answer)) {
            return toast($this, 'success', 'Answer has been deleted successfully!');
        }

        loggy(request(), 'Answer', auth()->user(), 'Deleted an answer | Answer ID: '.$this->answer->id);
        $this->answer->delete();
        $this->emit('refreshAnswers');

        return auth()->user()->touch();
    }
}
