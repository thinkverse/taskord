<?php

namespace App\Http\Livewire\User\Stats;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Livewire\Component;

class CompletedTasks extends Component
{
    public $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadCompletedTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $created_at = $this->user->created_at->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '10 days', $current_date);
        $completed_tasks_count = Task::cacheFor(60 * 60)
            ->select('id')
            ->where([
                ['user_id', $this->user->id],
                ['done', true],
            ])
            ->count();

        $week_dates = [];
        $completed_tasks = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = Task::cacheFor(60 * 60)
                ->select('id')
                ->where([
                    ['user_id', $this->user->id],
                    ['done', true],
                ])
                ->whereBetween('done_at', [carbon($date), carbon($date)->addDays(10)])
                ->count();
            array_push($completed_tasks, $count);
        }

        return view('livewire.user.stats.completed-tasks', [
            'week_dates' => $this->readyToLoad ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'completed_tasks' => $this->readyToLoad ? json_encode($completed_tasks, JSON_NUMERIC_CHECK) : [],
            'completed_tasks_count' => $this->readyToLoad ? $completed_tasks_count : '···',
        ]);
    }
}
