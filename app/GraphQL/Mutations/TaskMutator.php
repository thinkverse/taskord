<?php

namespace App\GraphQL\Mutations;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Gamify\Points\TaskCreated;
use Illuminate\Support\Facades\Gate;
use App\Actions\CreateNewTask;
use Helper;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class TaskMutator
{
    use WithRateLimiting;

    public function __invoke($_, array $args)
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            return [
                'status' => false,
                'message' => config('taskord.error.rate-limit'),
            ];
        }

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
