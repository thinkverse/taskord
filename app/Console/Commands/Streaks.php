<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\Task;

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
            $created_at = $user->created_at->format('Y-m-d');
            $current_date = carbon()->format('Y-m-d');
            $period = CarbonPeriod::create($created_at, $current_date);
            $streaks = 0;
            foreach ($period->toArray() as $date) {
                $count = Task::cacheFor(60 * 60)
                    ->select('id')
                    ->where('user_id', $user->id)
                    ->whereDate('created_at', carbon($date))
                    ->count();
                if ($count > 0) {
                    $streaks += 1;
                } else {
                    $streaks = 0;
                }
            }
            dump($streaks);
            
            $user->daily_goal_reached = 0;
            $this->info('Calculation Successful for @'.$user->username.'!');
            $user->save();
        }
        $this->info('Streaks Calculation Completed!');
        
        return 0;
    }
}
