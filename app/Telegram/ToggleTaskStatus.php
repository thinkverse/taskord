<?php

namespace App\Telegram;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Models\User;
use Helper;
use App\Actions\CreateNewTask;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Telegram;

class ToggleTaskStatus
{
    protected User $user;
    protected $id;
    protected $status;

    public function __construct(
        $user,
        $id,
        $status
    ) {
        $this->user = $user;
        $this->id = $id;
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

        if ($this->user->isFlagged) {
            return $this->send($this->user->telegram_chat_id, '🚩 Your account is flagged!');
        }
    }

    public function send($chat_id, $message)
    {
        return Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => $message,
            'disable_web_page_preview' => true,
            'parse_mode' => 'Markdown',
        ]);
    }
}
