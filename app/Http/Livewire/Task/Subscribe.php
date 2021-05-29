<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Subscribe extends Component
{
    use WithRateLimiting;
    
    public $listeners = [
        'refreshTaskSubscribed' => 'render',
    ];

    public Task $task;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function subscribeTask()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise', $this->question)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        auth()->user()->toggleSubscribe($this->task);
        $this->task->refresh();
        auth()->user()->touch();

        return loggy(request(), 'Task', auth()->user(), 'Toggled task subscribe | Task ID: '.$this->task->id);
    }

    public function render()
    {
        return view('livewire.task.subscribe');
    }
}
