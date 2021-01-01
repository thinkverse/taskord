<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public $listeners = [
        'taskSubscribed' => 'render',
    ];

    public Task $task;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function subscribeTask()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while subscribing to the task');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }
            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (user()->id === $this->task->user->id) {
                return $this->alert('warning', 'You can\'t subscribe your own task!');
            } else {
                user()->toggleSubscribe($this->task);
                $this->task->refresh();
                user()->touch();
                activity()
                    ->withProperties(['type' => 'Task'])
                    ->log('Toggled task subscribe | Task ID: '.$this->task->id);
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.task.subscribe');
    }
}
