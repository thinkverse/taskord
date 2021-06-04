<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

class Streaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:streaks {type=timezone}';

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
        $timezones = timezone_identifiers_list();
        $tzList = [];

        foreach ($timezones as $timezone) {
            $time = carbon()->tz($timezone)->format('H');
            if ($time === '23') {
                array_push($tzList, $timezone);
            }
        }

        $type = $this->arguments()['type'];

        if ($type === 'timezone') {
            $this->info('Calculating timezone based users streaks!');
            $users = User::select('id', 'username', 'timezone', 'streaks', 'created_at')
                ->whereIn('timezone', $tzList)
                ->get();
        } else {
            $this->info('Calculating all users streaks!');
            $users = User::select('id', 'username', 'timezone', 'streaks', 'created_at')
                ->get();
        }

        foreach ($users as $user) {
            $createdAt = $user->created_at->format('Y-m-d');
            $currentDate = carbon()->format('Y-m-d');
            $period = CarbonPeriod::create($createdAt, $currentDate);
            $streaks = 0;
            foreach ($period->toArray() as $date) {
                $count = $user->tasks()
                    ->select('id')
                    ->whereUserId($user->id)
                    ->whereDate('created_at', carbon($date))
                    ->count();
                if ($count > 0) {
                    $streaks += 1;
                } else {
                    $streaks = 0;
                }
            }

            if ($user->vacation_mode) {
                $this->info("Skipped streaks update for @{$user->username}! - {$streaks} Total Streaks");
            } else {
                $user->streaks = $streaks;
                $this->info("Calculation Successful for @{$user->username}! - {$streaks} Total Streaks");
                $user->save();
            }
        }
        $ops = User::whereUsername('ops')->first();
        loggy(request(), 'Staff', $ops, 'Resetted streaks for '.number_format(count($users)).' users in '.number_format(count($tzList)).' timezones');
        $this->info('Streaks Calculation Completed!');

        return 0;
    }
}
