<?php

namespace App\Jobs;

use App\Models\Oembed;
use Embed\Embed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetOembed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        preg_match_all(
            '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#',
            $this->task->task,
            $match
        );

        if (count($match[0]) === 0) {
            return true;
        }

        if (! @get_headers($match[0][0])) {
            return true;
        }

        $embed = new Embed();
        $info = $embed->get($match[0][0]);
        $metas = $info->getMetas();

        if (! $info->title) {
            return true;
        }

        $oembed = new Oembed();
        $oembed->url = $info->url;
        $oembed->title = $info->title;
        $oembed->description = $info->description;
        $oembed->provider_name = $info->providerName;
        $oembed->provider_url = $info->providerUrl;
        $oembed->type = $metas->str('twitter:card');
        $oembed->theme_color = $metas->str('theme-color');
        $oembed->thumbnail_url = $info->image;
        $oembed->favicon = $info->favicon;
        $this->task->oembed()->save($oembed);

        return true;
    }
}
