<?php

namespace App\GraphQL\Queries;

class AnswerQuery
{
    public function getAnswer($answer, array $args)
    {
        if (
            $answer->hidden or
            $answer->question->patronOnly or
            $answer->user->isFlagged
        ) {
            return null;
        }

        return $answer->answer;
    }

    public function hasPraised($answer, array $args)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($answer);
        } else {
            return null;
        }
    }
}
