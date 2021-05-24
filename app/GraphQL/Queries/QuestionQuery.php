<?php

namespace App\GraphQL\Queries;

class QuestionQuery
{
    public function hasPraised($question, array $args)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($question);
        } else {
            return null;
        }
    }
}
