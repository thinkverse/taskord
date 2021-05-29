<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Models\Task;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class SingleTask extends Component
{
    use WithRateLimiting;

    public $listeners = [
        'refreshSingleTask' => 'render',
    ];

    public Task $task;
    public $launched;
    public $showComments;

    public function mount($task, $showComments = true)
    {
        $this->task = $task;
        $this->showComments = $showComments;
    }

    public function checkTask()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();

        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }

        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while checking a task');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (Gate::denies('check.task', $this->task)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        if ($this->task->done) {
            $this->task->done_at = carbon();
            auth()->user()->touch();
            loggy(request(), 'Task', auth()->user(), 'Updated a task as pending | Task ID: '.$this->task->id);
        } else {
            $this->task->done_at = carbon();
            auth()->user()->touch();
            if (auth()->user()->has_goal) {
                auth()->user()->daily_goal_reached++;
                auth()->user()->save();
                CheckGoal::dispatch(auth()->user(), $this->task);
            }
            givePoint(new TaskCompleted($this->task));
            loggy(request(), 'Task', auth()->user(), 'Updated a task as done | Task ID: '.$this->task->id);
        }
        $this->task->done = ! $this->task->done;
        $this->task->save();

        return $this->emit('refreshTasks');
    }

    public function togglePraise()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', "Slow down! Please wait another $exception->secondsUntilAvailable seconds.");
        }

        if (Gate::denies('praise', $this->task)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::togglePraise($this->task, 'TASK');

        return loggy(request(), 'Task', auth()->user(), 'Toggled task praise | Task ID: '.$this->task->id);
    }

    public function hide()
    {
        if (Gate::denies('staff_mode')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::hide($this->task);
        loggy(request(), 'Staff', auth()->user(), 'Toggled task hide | Task ID: '.$this->task->id);

        return toast($this, 'success', 'Task is hidden from public!');
    }

    public function deleteTask()
    {
        if (Gate::denies('act', $this->task)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        loggy(request(), 'Task', auth()->user(), 'Deleted a task | Task ID: '.$this->task->id);
        foreach ($this->task->images ?? [] as $image) {
            Storage::delete($image);
        }
        $this->task->delete();
        $this->emitUp('refreshTasks');
        auth()->user()->touch();

        return toast($this, 'success', 'Task has been deleted successfully!');
    }

    public function render()
    {
        $this->launched = false;
        $launchList = [
            'launched',
            'launch',
            'shipped',
            'ship',
        ];

        $launchFound = false;
        foreach ($launchList as $keyword) {
            if (preg_match("/\b$keyword\b/", strtolower($this->task->task))) {
                $launchFound = true;
                break;
            }
        }

        if (($launchFound and (bool) $this->task->done)) {
            $this->launched = true;
        }

        return view('livewire.task.single-task');
    }
}
