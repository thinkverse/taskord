<?php

use Illuminate\Support\Facades\File;

return [

    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    // capture release as git sha
    'release' => 'Taskord v'.File::get('../VERSION'),

    'breadcrumbs' => [
        // Capture Laravel logs in breadcrumbs
        'logs' => true,

        // Capture SQL queries in breadcrumbs
        'sql_queries' => true,

        // Capture bindings on SQL queries logged in breadcrumbs
        'sql_bindings' => true,

        // Capture queue job information in breadcrumbs
        'queue_info' => true,

        // Capture command information in breadcrumbs
        'command_info' => true,
    ],

    // @see: https://docs.sentry.io/error-reporting/configuration/?platform=php#send-default-pii
    'send_default_pii' => false,

];
