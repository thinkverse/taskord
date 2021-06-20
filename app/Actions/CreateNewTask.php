<?php

namespace App\Actions;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Models\User;
use App\Models\Product;
use Helper;

class CreateNewTask
{
    private const DEFAULT_SOURCE = 'Taskord for Web';

    protected array $data;
    protected User $user;
    protected $product;

    public function __construct(User $user, $product, array $data)
    {
        $this->user = $user;
        $this->product = $product;
        $this->data = $data;
    }

    public function __invoke(): Task
    {
        $task = $this->createTaskModel();
        $this->updateActivity($task);

        return $task;
    }

    public function updateActivity(Task $task)
    {
        givePoint(new TaskCreated($task));
        $users = Helper::getUsernamesFromMentions($task->task);
        Helper::mentionUsers($users, $task, $this->user, 'task');
        $message = "Created a new task via {$task->source}";
        loggy(request(), 'Task', $this->user, \sprintf('%s | Task ID: %d', $message, $task->id));
    }

    public function createTaskModel(): Task
    {
        if (! $this->product) {
            $product_id = Helper::getProductIDFromMention($this->data['task'], auth()->user());
        } else {
            $product_id = $this->product->id;
        }

        return Task::create(
            \array_merge([
                'product_id' => $product_id,
                'user_id' => $this->user->id,
                'type' => $product_id ? 'product' : 'user',
                'source' => self::DEFAULT_SOURCE,
            ], $this->data)
        );
    }
}
