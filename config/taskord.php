<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Taskord Configuration
    |--------------------------------------------------------------------------
    */

    'tasks' => [
        'templates' => [
            'I just launched a new product! Check out #%s',
            'Check  out #%s, I just launched it today! 🚀',
        ],
    ],

    'error' => [
        'deny' => config('taskord.error.deny')
    ],

    'reserved_slugs' => [
        'launched',
        'new',
        'products',
        'unanswered',
        'popular',
        'admin',
        'staff',
        'stafftools',
        'tasks',
        'explore',
        'milestones',
        'help',
        'meetups',
        'settings',
        'deals',
        'open',
        'logout',
        'patron',
        'reputation',
        'notifications',
    ],

];
