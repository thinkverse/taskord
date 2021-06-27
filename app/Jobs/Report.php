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

class Report implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $description;

    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function handle()
    {
        if (App::environment() === 'production') {
            $client = new Client();
            $client->request('POST', 'https://gitlab.com/api/v4/projects/20359920/issues', [
                'headers' => [
                    'PRIVATE-TOKEN' => config('services.gitlab.pat'),
                ],
                'json' => [
                    'title' => $this->title,
                    'description' => $this->description,
                ],
            ]);
        }

        Artisan::call('app:clean');
    }
}
