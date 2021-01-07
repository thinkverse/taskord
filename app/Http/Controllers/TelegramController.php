<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewTask;
use App\Telegram\CreateTask;
use App\Telegram\Stats;
use App\Telegram\Pending;
use App\Telegram\ToggleTaskStatus;
use App\Telegram\Logout;
use App\Telegram\AuthUser;
use App\Models\Task;
use App\Models\User;
use GuzzleHttp\Client;
use Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Telegram;

class TelegramController extends Controller
{
    public function getUpdates()
    {
        $updates = Telegram::getWebhookUpdates();
        if (isset($updates->message['message_id'])) {
            if (isset($updates->message['photo'])) {
                $message = isset($updates->message['caption']) ? $updates->message['caption'] : '/start';
                $file_id = $updates->message['photo'][1]['file_id'];
                $chat_id = $updates->message['from']['id'];
            } elseif (
                isset($updates->message['document']) or // Avoid Document
                isset($updates->message['sticker']) // Avoid Sticker
            ) {
                $message = '/start';
                $chat_id = $updates->message['from']['id'];
            } else {
                $message = $updates->message['text'];
                $file_id = null;
                $chat_id = $updates->message['from']['id'];
            }
        } else {
            return false;
        }
        
        $user = User::where('telegram_chat_id', $chat_id)->first();

        if (Str::of($message)->startsWith('/auth')) {
            $token = substr($message, strpos($message, '/auth') + 6);
            return (new AuthUser($token, $chat_id))();
        } elseif (Str::of($message)->startsWith('/todo')) {
            if ($this->authCheck($chat_id)) {
                $task = substr($message, strpos($message, '/todo') + 6);
                return (new CreateTask($user, $task, $file_id, false))();
            }
        } elseif (Str::of($message)->startsWith('/done')) {
            if ($this->authCheck($chat_id)) {
                $task = substr($message, strpos($message, '/done') + 6);
                return (new CreateTask($user, $task, $file_id, true))();
            }
        } elseif (Str::of($message)->startsWith('/complete')) {
            if ($this->authCheck($chat_id)) {
                $id = substr($message, strpos($message, '/complete') + 10);
                return (new ToggleTaskStatus($user, $id, true))();
            }
        } elseif (Str::of($message)->startsWith('/uncomplete')) {
            if ($this->authCheck($chat_id)) {
                $id = substr($message, strpos($message, '/complete') + 12);
                return (new ToggleTaskStatus($user, $id, false))();
            }
        } elseif (Str::of($message)->startsWith('/pending')) {
            if ($this->authCheck($chat_id)) {
                return (new Pending($user))();
            }
        } elseif (Str::of($message)->startsWith('/logout')) {
            if ($this->authCheck($chat_id)) {
                return (new Logout($chat_id))();
            }
        } elseif (Str::of($message)->startsWith('/start')) {
            if ($this->authCheck($chat_id)) {
                return (new Stats($user))();
            }
        } elseif (Str::of($message)->startsWith('/stats')) {
            if ($this->authCheck($chat_id)) {
                return (new Stats($user))();
            }
        } else {
            return $this->send($chat_id, 'Please enter the valid command!');
        }
    }

    public function start($chat_id)
    {
        $res = "*Hi 👋, I'm Taskord Bot, I can help you stay productive without leaving your chat application.*\n\n"
               ."You can use these commands\n\n"
               ."*New Task*\n\n"
               ."/todo `<task>` - Create a new pending task\n"
               ."/done `<task>` - Create a new completed task\n\n"
               ."*Task Status*\n\n"
               ."/complete `<task id>` - Complete a pending task\n"
               ."/uncomplete `<task id>` - Uncomplete a completed task\n\n"
               ."*Profile*\n\n"
               ."/stats - See your account stats\n"
               ."/pending - See all pending tasks\n\n"
               ."*Account*\n\n"
               ."/auth `<API token>` - Connect Taskord account with Telegram\n"
               ."/logout - Disconnect Taskord account from Telegram\n\n"
               ."*Others*\n\n"
               ."/start - See this message again anytime\n";

        return $this->send($chat_id, $res);
    }

    public function authCheck($chat_id)
    {
        $user = User::where('telegram_chat_id', $chat_id)->first();
        if ($user) {
            return true;
        } else {
            $this->send($chat_id, '🔒 *You\'re not logged in. /auth <token> to begin*');

            return false;
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
