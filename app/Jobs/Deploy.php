<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class Deploy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        if (App::environment() === 'production') {
            $client = new Client();
            $res = $client->request('GET', 'https://app.buddy.works/yogi/taskord/pipelines/pipeline/334241/trigger-webhook', [
                'query' => [
                    'token' => env("BUDDYWORKS_TOKEN"),
                ],
            ]);

            dd($res);
        }
    }
}
