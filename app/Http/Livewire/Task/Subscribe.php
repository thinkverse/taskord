<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

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
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise/subscribe', $this->task)) {
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
