<?php

namespace App\GraphQL\Mutations;

use App\Gamify\Points\TaskCreated;
use App\Models\Comment;
use Helper;
use Illuminate\Support\Facades\Gate;

class CommentMutator
{
    public function createTask($_, array $args)
    {
        if (Gate::denies('create')) {
            return [
                'status' => false,
                'message' => 'Permission denied!',
            ];
        }

        $product_id = Helper::getProductIDFromMention($args['task'], auth()->user());

        $task = (new CreateNewTask(auth()->user(), [
            'product_id' => $product_id,
            'task' => $args['task'],
            'done' => $args['done'],
            'done_at' => $args['done'] ? carbon() : null,
            'type' => 'user',
            'type' => $product_id ? 'product' : 'user',
            'source' => 'Taskord API',
        ]))();

        givePoint(new TaskCreated($task));

        return [
            'status' => true,
            'message' => 'Task created successfully',
            'task' => $task,
        ];
    }
}
