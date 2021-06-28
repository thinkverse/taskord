<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Report implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $title;
    protected $description;

    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function handle()
    {
        $client = new Client();
        $client->request('POST', 'https://gitlab.com/api/v4/projects/20359920/issues', [
            'headers' => [
                'PRIVATE-TOKEN' => config('services.gitlab.pat'),
            ],
            'json' => [
                'title'       => $this->title,
                'description' => "{$this->description}\n\n<small>Reported from Taskord Stafftools</small>",
            ],
        ]);
    }
}
