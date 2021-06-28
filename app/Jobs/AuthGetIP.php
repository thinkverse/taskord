<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class AuthGetIP implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $user;
    protected $ip;

    public function __construct($user, $ip)
    {
        $this->user = $user;
        $this->ip = $ip;
    }

    public function handle()
    {
        if (App::environment() === 'production') {
            try {
                $ipInfo = file_get_contents('http://ip-api.com/json/'.$this->ip);
                $ipInfo = json_decode($ipInfo);
                if ($ipInfo->status !== 'fail') {
                    $this->user->last_ip = $this->ip;
                    $this->user->timezone = $ipInfo->timezone;
                    $this->user->save();
                }
            } catch (Exception $e) {
                return 'IP API Rate limited';
            }
        }
    }
}
