<?php

namespace App\GraphQL\Queries;

class CommentQuery
{
    public function hasPraised($comment, array $args)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($comment);
        }

        return null;
    }
}
