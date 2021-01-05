<?php

return [
    'bots' => [
        'taskordbot' => [
            'username' => 'TELEGRAM_BOT_USERNAME',
            'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR-BOT-TOKEN'),
            'certificate_path' => env('TELEGRAM_CERTIFICATE_PATH', 'YOUR-CERTIFICATE-PATH'),
            'webhook_url' => env('TELEGRAM_WEBHOOK_URL', 'YOUR-BOT-WEBHOOK-URL'),
            'commands' => [
                //Acme\Project\Commands\MyTelegramBot\BotCommand::class
            ],
        ],
    ],
    'default' => 'taskordbot',
    'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', false),
    'http_client_handler' => null,
    'resolve_command_dependencies' => true,
    'commands' => [
        Telegram\Bot\Commands\HelpCommand::class,
    ],
    'command_groups' => [],
    'shared_commands' => [],
];
