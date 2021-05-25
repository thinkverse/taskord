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
        $createdAt = carbon('Sep 1 2020')->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, '7 days', $currentDate);
        $allTasksCount = Task::select('id')
            ->count();

        $weekDates = [];
        $all_tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = Task::select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($all_tasks, $count);
        }

        return view('livewire.pages.open.all-tasks', [
            'week_dates' => json_encode($weekDates, JSON_NUMERIC_CHECK),
            'all_tasks' => $this->readyToLoad ? json_encode($all_tasks, JSON_NUMERIC_CHECK) : [],
            'all_tasks_count' => $this->readyToLoad ? number_format($allTasksCount) : '···',
        ]);
    }
}
