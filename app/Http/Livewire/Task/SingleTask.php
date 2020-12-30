<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Models\Task;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class SingleTask extends Component
{
    public Task $task;
    public $confirming;
    public $launched;
    public $bug;
    public $learn;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function checkTask()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while checking the task');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (Auth::id() === $this->task->user->id) {
                if ($this->task->done) {
                    $this->task->done_at = Carbon::now();
                    Auth::user()->touch();
                    activity()
                        ->withProperties(['type' => 'Task'])
                        ->log('Updated a task as pending | Task ID: '.$this->task->id);
                } else {
                    $this->task->done_at = Carbon::now();
                    Auth::user()->touch();
                    if (Auth::user()->hasGoal) {
                        Auth::user()->daily_goal_reached++;
                        Auth::user()->save();
                        CheckGoal::dispatch(Auth::user(), $this->task);
                    }
                    givePoint(new TaskCompleted($this->task));
                    activity()
                        ->withProperties(['type' => 'Task'])
                        ->log('Updated a task as done | Task ID: '.$this->task->id);
                }
                $this->task->done = ! $this->task->done;
                $this->task->save();
                $this->emitUp('taskChecked');

                return true;
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while praising the task');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->task->user->id) {
                return $this->alert('warning', 'You can\'t praise your own task!');
            }
            Helper::togglePraise($this->task, 'TASK');
            activity()
                ->withProperties(['type' => 'Task'])
                ->log('Toggled task praise | Task ID: '.$this->task->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (Auth::user()->isStaff and Auth::user()->staffShip) {
                Helper::hide($this->task);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Toggled task hide | Task ID: '.$this->task->id);

                return $this->alert('success', 'Task is hidden from public!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->task->id;
    }

    public function deleteTask()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->task->user->id) {
                activity()
                    ->withProperties(['type' => 'Task'])
                    ->log('Deleted a task | Task ID: '.$this->task->id);
                foreach ($this->task->images ?? [] as $image) {
                    Storage::delete($image);
                }
                $this->task->delete();
                $this->emitUp('taskDeleted');
                Auth::user()->touch();

                return $this->alert('success', 'Task has been deleted successfully!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        $this->launched = false;
        $this->bug = false;
        $this->learn = false;
        $launchList = [
            'launched',
            'launch',
            'shipped',
            'ship',
        ];
        if (
            (Str::contains(strtolower($this->task->task), $launchList) and (bool) $this->task->done) and
            ($this->task->source !== 'GitHub' and $this->task->source !== 'GitLab' and $this->task->source !== 'Webhook')
        ) {
            $this->launched = true;
        }

        $bugList = [
            'bug',
            'fix',
            'fixed',
            'fixes',
        ];
        if (Str::contains(strtolower($this->task->task), $bugList) and (bool) $this->task->done) {
            $this->bug = true;
        }

        $learnList = [
            'learned',
            'learning',
            'learn',
        ];
        if (Str::contains(strtolower($this->task->task), $learnList) and (bool) $this->task->done) {
            $this->learn = true;
        }

        return view('livewire.task.single-task');
    }
}
