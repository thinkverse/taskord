<?php

namespace App\Http\Livewire\User;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Livewire\Component;

class Graph extends Component
{
    public $readyToLoad = false;
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function loadGraph()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $start_date = carbon('60 days ago')->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($start_date, $current_date);

        $week_dates = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = Task::cacheFor(86400)
                ->select('id', 'created_at')
                ->where('user_id', $this->user_id)
                ->whereDate('created_at', carbon($date))
                ->count();

            array_push($tasks, $count);
        }

        return view('livewire.user.graph', [
            'week_dates' => $this->readyToLoad ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'tasks' => $this->readyToLoad ? json_encode($tasks, JSON_NUMERIC_CHECK) : [],
        ]);
    }
}
