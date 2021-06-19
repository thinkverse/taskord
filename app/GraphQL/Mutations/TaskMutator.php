<?php

namespace App\GraphQL\Mutations;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Gamify\Points\TaskCreated;
use Illuminate\Support\Facades\Gate;
use App\Actions\CreateNewTask;

class TaskMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if (Gate::denies('create')) {
            return [
                'status' => false,
                'message' => 'Permission denied!',
            ];
        }

        $task = (new CreateNewTask(auth()->user(), [
            'product_id' => null,
            'task' => $args['task'],
            'done' => $args['done'],
            'done_at' => $args['done'] ? carbon()->now() : null,
            'type' => 'user',
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
