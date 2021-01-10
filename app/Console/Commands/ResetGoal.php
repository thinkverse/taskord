<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetGoal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-goal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all users daily goal';

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
            $user->daily_goal_reached = 0;
            $this->info('Reset Successful for @'.$user->username.'!');
            $user->save();
        }
        loggy(request()->ip(), 'Auth', auth()->user(), 'Daily goals has been resetted');
        $this->info('Reset Completed!');

        return 0;
    }
}
