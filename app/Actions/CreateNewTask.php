<?php

namespace App\Actions;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Models\User;
use Helper;

class CreateNewTask
{
    private const DEFAULT_SOURCE = 'Taskord for Web';

    protected array $data;
    protected User $user;

    public function __construct(User $user, array $data) {
        $this->user = $user;
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
        givePoint(new TaskCreated($task, $this->user));
        $users = Helper::getUsernamesFromMentions($task->task);
        Helper::mentionUsers($users, $task, $this->user, 'task');
        $message = "Created a new task via {$task->source}";
        loggy('Task', $this->user, \sprintf('%s | Task ID: %d', $message, $task->id));
    }

    public function createTaskModel(): Task
    {
        return Task::create(
            \array_merge([
                'user_id' => $this->user->id,
                'source' => CreateNewTask::DEFAULT_SOURCE,
            ], $this->data)
        );
    }
}
