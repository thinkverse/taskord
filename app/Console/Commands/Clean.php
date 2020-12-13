<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Clean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean the entire app';

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
        $this->info('Cleaning Started ✅');
        Artisan::call('config:cache');
        $this->info('Config Cached ✅');
        Artisan::call('config:clear');
        $this->info('Config Cleared ✅');
        Artisan::call('view:clear');
        $this->info('Views Cleared ✅');
        Artisan::call('cache:clear');
        $this->info('Cache Cleared ✅');
        Artisan::call('lighthouse:clear-cache');
        $this->info('Lighthouse Cache Cleared ✅');
        $this->info('Cleaning Ended ✅');

        return 0;
    }
}
