<?php

namespace App\GraphQL\Queries;

class AnswerQuery
{
    public function hasPraised($answer, array $args)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($answer);
        }

        return null;
    }
}
