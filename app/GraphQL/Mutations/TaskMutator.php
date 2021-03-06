<?php

namespace App\GraphQL\Mutations;

use App\Actions\CreateNewTask;
use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TaskMutator
{
    public function createTask($_, array $args)
    {
        if (Gate::denies('create')) {
            return [
                'status'  => false,
                'message' => 'Permission denied!',
            ];
        }

        $productId = Helper::getProductIDFromMention($args['task'], auth()->user());

        $task = (new CreateNewTask(auth()->user(), [
            'product_id' => $productId,
            'task'       => trim($args['task']),
            'done'       => $args['done'],
            'done_at'    => $args['done'] ? carbon() : null,
            'type'       => 'user',
            'type'       => $productId ? 'product' : 'user',
            'source'     => 'Taskord API',
        ]))();

        givePoint(new TaskCreated($task));

        return [
            'status'  => true,
            'message' => 'Task created successfully',
            'task'    => $task,
        ];
    }

    public function deleteTask($_, array $args)
    {
        $task = Task::find($args['id']);

        if (! $task) {
            return [
                'status'  => false,
                'message' => 'No task found!',
            ];
        }

        if (Gate::denies('edit/delete', $task)) {
            return [
                'status'  => false,
                'message' => config('taskord.toast.deny'),
            ];
        }

        loggy(request(), 'Task', auth()->user(), "Deleted a task | Task ID: {$task->id}");
        foreach ($task->images ?? [] as $image) {
            Storage::delete($image);
        }
        if ($task->oembed) {
            $task->oembed->delete();
        }
        $task->delete();

        return [
            'status'  => true,
            'message' => 'Task deleted successfully',
            'task'    => $task,
        ];
    }

    public function toggleLikeTask($_, array $args)
    {
        $task = Task::find($args['id']);

        if (! $task) {
            return [
                'status'  => false,
                'message' => 'No task found!',
            ];
        }

        if (Gate::denies('like/subscribe', $task)) {
            return [
                'status'  => false,
                'message' => config('taskord.toast.deny'),
            ];
        }

        Helper::toggleLike($task, 'TASK');
        loggy(request(), 'Task', auth()->user(), "Toggled task like | Task ID: {$task->id}");

        return [
            'status'  => true,
            'message' => 'Task deleted successfully',
            'task'    => $task,
        ];
    }
}
