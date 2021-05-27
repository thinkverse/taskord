<?php

namespace App\Telegram;

use App\Models\Task;
use App\Models\User;
use Telegram;

class ToggleTaskStatus
{
    protected User $user;
    protected $messageId;
    protected $status;

    public function __construct(
        $user,
        $messageId,
        $status
    ) {
        $this->user = $user;
        $this->id = $messageId;
        $this->status = $status;
    }

    public function __invoke()
    {
        if (! $this->id) {
            return $this->send($this->user->telegram_chat_id, '⚠ You should give *Task ID* `Eg: /done 28`');
        }

        if (! $this->user->hasVerifiedEmail()) {
            return $this->send($this->user->telegram_chat_id, '💌 Your email is not verified!');
        }

        if ($this->user->spammy) {
            return $this->send($this->user->telegram_chat_id, '🚩 Your account is flagged!');
        }

        $task = Task::find($this->id);
        if ($task) {
            if ($this->status) {
                if ($task->done) {
                    return $this->send($this->user->telegram_chat_id, 'Task [#'.$task->id.'](https://taskord.com/task/'.$task->id.') is *already done* ✅');
                } else {
                    $task->done = true;
                    $task->done_at = carbon();
                    $task->save();

                    return $this->send($this->user->telegram_chat_id, 'Task [#'.$task->id.'](https://taskord.com/task/'.$task->id.') has been *marked as done* ✅');
                }
            } else {
                if (! $task->done) {
                    return $this->send($this->user->telegram_chat_id, 'Task [#'.$task->id.'](https://taskord.com/task/'.$task->id.') is *already pending* ⏳');
                } else {
                    $task->done = false;
                    $task->done_at = null;
                    $task->save();

                    return $this->send($this->user->telegram_chat_id, 'Task [#'.$task->id.'](https://taskord.com/task/'.$task->id.') has been *marked as pending* ⏳');
                }
            }
        } else {
            return $this->send($this->user->telegram_chat_id, 'Oops! Task not exist 🙅');
        }
    }

    public function send($chatId, $message)
    {
        return Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
            'disable_web_page_preview' => true,
            'parse_mode' => 'Markdown',
        ]);
    }
}
