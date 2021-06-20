<?php

namespace App\GraphQL\Mutations;

use App\Gamify\Points\TaskCreated;
use App\Models\Comment;
use Helper;
use Illuminate\Support\Facades\Gate;

class CommentMutator
{
    public function createComment($_, array $args)
    {
        if (Gate::denies('create')) {
            return [
                'status' => false,
                'message' => 'Permission denied!',
            ];
        }

        $users = Helper::getUsernamesFromMentions($args['comment']);

        if ($users) {
            $comment = Helper::parseUserMentionsToMarkdownLinks($comment, $users);
        }

        $comment = auth()->user()->comments()->create([
            'task_id' => $args['task_id'],
            'comment' => $args['comment'],
        ]);

        Helper::mentionUsers($users, $comment, auth()->user(), 'comment');
        Helper::notifySubscribers($comment->task->subscribers, $comment, 'comment');

        if (auth()->user()->id !== $comment->task->user->id) {
            if (! auth()->user()->hasSubscribed($comment->task)) {
                auth()->user()->subscribe($comment->task);
            }
            $comment->task->user->notify(new Commented($comment));
            givePoint(new CommentCreated($comment));
        }
        loggy(request(), 'Comment', auth()->user(), "Created a new comment | Comment ID: {$comment->id}");

        return [
            'status' => true,
            'message' => 'Comment created successfully',
            'comment' => $comment,
        ];
    }
}
