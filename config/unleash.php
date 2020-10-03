<?php

return [
    // URL of the Unleash server.
    // This should be the base URL, do not include /api or anything else.
    'url' => env('UNLEASH_URL', 'https://gitlab.com'),
    'instance_id' => env('UNLEASH_INSTANCE_ID'),
    'project_id' => env('UNLEASH_PROJECT_ID'),
    'app_name'  => env('APP_NAME'),

    // Globally control whether Unleash is enabled or disabled.
    // If not enabled, no API requests will be made and all "enabled" checks will return `false` and
    // "disabled" checks will return `true`.
    'isEnabled' => env('UNLEASH_ENABLED', true),

    // Allow the Unleash API response to be cached.
    'cache' => [
        'isEnabled' => true,
        'ttl' => 3600,
    ],

    // Mapping of strategies used to guard features on Unleash. The default strategies are already
    // mapped below, and more strategies can be added - they just need to implement the
    // `\Taskord\LaravelUnleash\Strategies\Strategy` interface. If you would like to disable
    // a built-in strategy, please comment it out or remove it below.
    'strategies' => [
        'applicationHostname' => \Taskord\LaravelUnleash\Strategies\ApplicationHostnameStrategy::class,
        'default' => \Taskord\LaravelUnleash\Strategies\DefaultStrategy::class,
        'remoteAddress' => \Taskord\LaravelUnleash\Strategies\RemoteAddressStrategy::class,
        'userWithIds' => \Taskord\LaravelUnleash\Strategies\UserWithIdStrategy::class,
    ],
];
