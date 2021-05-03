<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class StatusController extends Controller
{
    public function ping()
    {
        return 'pong';
    }

    public function redis()
    {
        try {
            $redis = Redis::connect('127.0.0.1', 3306);

            return 'ok';
        } catch (\Exception $e) {
            return 'not ok';
        }
    }

    public function redisCache()
    {
        return Cache::remember('status', 60 * 60, function () {
            return 'ok';
        });
    }
}
