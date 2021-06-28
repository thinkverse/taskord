<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\View\View;
use Livewire\Component;

class Graph extends Component
{
    public $readyToLoad = false;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadGraph()
    {
        $this->readyToLoad = true;
    }

    public function getGraph($type)
    {
        $startDate = carbon('60 days ago')->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($startDate, $currentDate);

        $weekDates = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = $this->user->tasks()
                ->select('id', 'created_at')
                ->whereDate('created_at', carbon($date))
                ->count();

            array_push($tasks, $count);
        }

        if ($type === 'tasks') {
            return $tasks;
        }

        return $weekDates;
    }

    public function render(): View
    {
        return view('livewire.user.graph', [
            'week_dates' => $this->readyToLoad ? json_encode($this->getGraph('week_dates'), JSON_NUMERIC_CHECK) : [],
            'tasks'      => $this->readyToLoad ? json_encode($this->getGraph('tasks'), JSON_NUMERIC_CHECK) : [],
            'count'      => $this->readyToLoad ? array_sum($this->getGraph('tasks')) : 0,
        ]);
    }
}
