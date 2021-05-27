<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class StaffController extends Controller
{
    public static function toggle()
    {
        if (auth()->user()->staff_mode) {
            auth()->user()->staff_mode = false;
            auth()->user()->save();
            loggy(request(), 'Staff', auth()->user(), 'Disabled staff ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        }

        auth()->user()->staff_mode = true;
        auth()->user()->save();
        loggy(request(), 'Staff', auth()->user(), 'Enabled staff ship');

        return response()->json([
            'status' => 'enabled',
        ]);
    }

    public static function commitData()
    {
        $client = new Client(['http_errors' => false]);
        $commit = $client->request('GET', 'https://gitlab.com/api/v4/projects/20359920/repository/commits', [
            'query' => [
                'per_page' => 1,
            ],
        ]);

        if ($commit->getStatusCode() === 200) {
            return view('site.commit', [
                'commit' => json_decode($commit->getBody()->getContents())[0],
            ]);
        }

        return 'Something went wrong!';
    }

    public static function ciData()
    {
        $client = new Client(['http_errors' => false]);
        $ci = $client->request('GET', 'https://gitlab.com/api/v4/projects/20359920/pipelines', [
            'query' => [
                'per_page' => 1,
                'ref' => 'main',
            ],
        ]);

        if ($ci->getStatusCode() === 200) {
            return view('site.ci', [
                'ci' => json_decode($ci->getBody()->getContents())[0],
            ]);
        }

        return 'Something went wrong!';
    }

    public static function deploymentData()
    {
        $client = new Client(['http_errors' => false]);
        $deployments = $client->request('GET', 'https://gitlab.com/api/v4/projects/25370928/jobs', [
            'query' => [
                'access_token' => config('services.gitlab.pat'),
                'per_page' => 5,
                'ref' => 'master',
            ],
        ]);

        if ($deployments->getStatusCode() === 200) {
            return view('site.deployment', [
                'deployments' => json_decode($deployments->getBody()->getContents()),
            ]);
        }

        return 'Something went wrong!';
    }

    public static function system()
    {
        // Memory Info
        $memFile = file_get_contents('/proc/meminfo');
        preg_match_all('/(\w+):\s+(\d+)\s/', $memFile, $matches);
        $meminfo = array_combine($matches[1], $matches[2]);

        // Uptime
        $uptime = explode(',', explode(' up ', shell_exec('uptime'))[1])[0];

        // CPU
        $cpuinfoFile = file_get_contents('/proc/cpuinfo');
        preg_match_all('/^processor/m', $cpuinfoFile, $matches);
        $ncpu = count($matches[0]);

        return view('staff.system', [
            'meminfo' => $meminfo,
            'uptime' => $uptime,
            'ncpu' => $ncpu,
        ]);
    }
}
