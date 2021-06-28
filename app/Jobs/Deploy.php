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
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle()
    {
        if (App::environment() === 'production') {
            $client = new Client();

            return $client->request('GET', 'https://app.buddy.works/yogi/taskord/pipelines/pipeline/334241/trigger-webhook', [
                'query' => [
                    'token' => config('services.buddy.webhook_token'),
                ],
            ]);
        }
    }
}
