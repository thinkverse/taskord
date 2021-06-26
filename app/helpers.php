<?php

declare(strict_types=1);

use App\Jobs\LogActivity;
use App\Models\Feature;
use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

if (! function_exists('git')) {
    function git(string $args): ?string
    {
        if (! in_array(explode(' ', $args)[0], ['rev-parse'], true)) {
            return null;
        }

        $output = shell_exec(escapeshellcmd("git ${args}"));

        if (is_null($output) || str_contains('fatal', $output)) {
            return null;
        }

        return trim($output);
    }
}

if (! function_exists('laravel_version')) {
    function laravel_version(): string
    {
        return Application::VERSION;
    }
}

if (! function_exists('memoryUsage')) {
    function memoryUsage(): string
    {
        $memUsage = memory_get_usage(true);

        if ($memUsage < 1024) {
            $format = sprintf('%dB', $memUsage);
        } elseif ($memUsage < 1048576) {
            $format = sprintf('%dKB', round($memUsage / 1024, 2));
        } else {
            $format = sprintf('%dMB', round($memUsage / 1048576, 2));
        }

        return $format;
    }
}

if (! function_exists('pluralize')) {
    function pluralize($word, $count): string
    {
        return Str::plural($word, $count);
    }
}

if (! function_exists('carbon')) {
    function carbon(...$args): ?Carbon
    {
        try {
            return new Carbon(...$args);
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (! function_exists('loggy')) {
    function loggy($request, $type, $user, $message)
    {
        return LogActivity::dispatch(
            $request->ip(),
            $request->header('User-Agent'),
            $type,
            $user,
            $message
        );
    }
}

if (! function_exists('formatBytes')) {
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['', 'KB', 'MB', 'GB', 'TB'];

        return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
    }
}

if (! function_exists('markdown')) {
    function markdown($content)
    {
        return Str::markdown($content, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }
}

if (! function_exists('feature')) {
    function feature($slug)
    {
        try {
            return Feature::enabled($slug);
        } catch (Throwable $e) {
            return false;
        }
    }
}

if (! function_exists('toast')) {
    function toast($livewire, $type, $body)
    {
        return $livewire->dispatchBrowserEvent('toast', [
            'type' => $type,
            'body' => $body,
        ]);
    }
}
