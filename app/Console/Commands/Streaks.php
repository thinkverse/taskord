<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class Streaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:streaks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Streaks of an user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $created_at = $this->user->created_at->format('Y-m-d');
            $current_date = carbon()->format('Y-m-d');
            $period = CarbonPeriod::create($created_at, '5 days', $current_date);
            $all_tasks_count = Task::cacheFor(60 * 60)
                ->select('id')
                ->where('user_id', $this->user->id)
                ->count();
    
            $week_dates = [];
            $all_tasks = [];
            $tasks = [];
            foreach ($period->toArray() as $date) {
                array_push($week_dates, carbon($date)->format('d M Y'));
                $count = Task::cacheFor(60 * 60)
                    ->select('id')
                    ->where('user_id', $this->user->id)
                    ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(5)])
                    ->count();
                array_push($all_tasks, $count);
            }
            
            $user->daily_goal_reached = 0;
            $this->info('Calculation Successful for @'.$user->username.'!');
            $user->save();
        }
        $this->info('Streaks Calculation Completed!');
        
        return 0;
    }
}
