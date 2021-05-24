<?php

namespace App\GraphQL\Queries;

class TaskQuery
{
    public function hasPraised($task, array $args)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($task);
        } else {
            return null;
        }
    }
}
