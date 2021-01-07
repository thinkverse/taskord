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
        $user = User::where('api_token', $this->token)->first();
        $user_count = User::where('telegram_chat_id', $user->telegram_chat_id)->count('id');
        if (! $user or strlen($this->token) !== 60) {
            $helper = "Go to https://taskord.com/settings/api and copy your *API Token 🔑*\n\n"
                .'And paste it here `/auth <API token>`';

            return $this->send($this->chat_id, $helper);
        }
        
        if ($user_count > 1) {
            return $this->send($this->chat_id, "*This Telegram account is already associated with another account* 👀");
        }

        if ($user->telegram_chat_id) {
            return $this->send($user->telegram_chat_id, '*You are already authenticated* ✅');
        } else {
            $user->telegram_chat_id = $this->chat_id;
            $user->save();

            return $this->send($user->telegram_chat_id, '*Authentication successful* ✅');
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
