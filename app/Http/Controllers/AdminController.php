<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public static function toggle()
    {
        if (auth()->user()->staffShip) {
            auth()->user()->staffShip = false;
            auth()->user()->save();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            auth()->user()->staffShip = true;
            auth()->user()->save();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }

    public static function cacheHits()
    {
        $cache = Cache::getStore()->getMemcached()->getAllKeys();

        return view('site.cache', [
            'cache' => array_reverse($cache),
        ]);
    }

    public static function commitData()
    {
        $client = new Client();
        $commit = $client->request('GET', 'https://gitlab.com/api/v4/projects/20359920/repository/commits', [
            'query' => [
                'per_page' => 1,
            ],
        ]);

        return view('site.commit', [
            'commit' => json_decode($commit->getBody()->getContents())[0],
        ]);
    }

    public static function ciData()
    {
        $client = new Client();
        $ci = $client->request('GET', 'https://gitlab.com/api/v4/projects/20359920/pipelines', [
            'query' => [
                'per_page' => 1,
            ],
        ]);

        return view('site.ci', [
            'ci' => json_decode($ci->getBody()->getContents())[0],
        ]);
    }
}
