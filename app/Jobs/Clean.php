<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class Clean implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        if (App::environment() === 'production') {
            $client = new Client();
            $res = $client->request('POST', 'https://api.cloudflare.com/client/v4/zones/06be44cac798e7deeb4abda1378c4339/purge_cache', [
                'headers' => [
                    'X-Auth-Email' => config('services.cloudflare.email'),
                    'X-Auth-Key'   => config('services.cloudflare.api_key'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'purge_everything' => true,
                ],
            ]);
        }

        Artisan::call('app:clean');
    }
}
