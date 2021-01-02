<?php

namespace App\Http\Livewire\Pages\Open;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Livewire\Component;

class AllTasks extends Component
{
    public $readyToLoad = false;

    public function loadAllTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $created_at = carbon('Sep 1 2020')->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '7 days', $current_date);
        $all_tasks_count = Task::cacheFor(60 * 60)
            ->select('id')
            ->count();

        $week_dates = [];
        $all_tasks = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = Task::cacheFor(60 * 60)
                ->select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($all_tasks, $count);
        }

        return view('livewire.pages.open.all-tasks', [
            'week_dates' => json_encode($week_dates, JSON_NUMERIC_CHECK),
            'all_tasks' => $this->readyToLoad ? json_encode($all_tasks, JSON_NUMERIC_CHECK) : [],
            'all_tasks_count' => $this->readyToLoad ? number_format($all_tasks_count) : '···',
        ]);
    }
}
