<?php

namespace App\Http\Livewire\Product;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Livewire\Component;

class Graph extends Component
{
    public $readyToLoad = false;
    public $product_id;

    public function mount($product_id)
    {
        $this->product_id = $product_id;
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
                ->where('product_id', $this->product_id)
                ->whereDate('created_at', carbon($date))
                ->count();

            array_push($tasks, $count);
        }

        return view('livewire.product.graph', [
            'week_dates' => $this->readyToLoad ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'tasks' => $this->readyToLoad ? json_encode($tasks, JSON_NUMERIC_CHECK) : [],
            'count' => $this->readyToLoad ? array_sum($tasks) : 0,
        ]);
    }
}
