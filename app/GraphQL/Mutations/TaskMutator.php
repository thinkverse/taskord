<?php

namespace App\GraphQL\Mutations;

use App\Actions\CreateNewTask;
use App\Models\Task;
use App\Gamify\Points\TaskCreated;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TaskMutator
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

    public function deleteTask($_, array $args)
    {
        $task = Task::find($args['id']);

        if (! $task) {
            return [
                'status' => false,
                'message' => "No task found!",
            ];
        }

        if (Gate::denies('edit/delete', $this->task)) {
            return [
                'status' => false,
                'message' => config('taskord.toast.deny'),
            ];
        }

        loggy(request(), 'Task', auth()->user(), "Deleted a task | Task ID: {$task->id}");
        foreach ($task->images ?? [] as $image) {
            Storage::delete($image);
        }
        $this->task->delete();
        $this->emitUp('refreshTasks');
        auth()->user()->touch();

        return [
            'status' => true,
            'message' => 'Task created successfully',
            'task' => $task,
        ];
    }
}
