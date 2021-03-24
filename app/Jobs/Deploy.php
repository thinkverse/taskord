<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class Deploy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (App::environment() === 'production') {
            $client = new Client();
            $res = $client->request('POST', 'https://gitlab.com/api/v4/projects/25370928/ref/master/trigger/pipeline', [
                'form_params' => [
                    'token' => config('services.gitlab.trigger_token'),
                ],
            ]);
        }
    }
}