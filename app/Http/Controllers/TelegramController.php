<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewTask;
use App\Telegram\CreateTask;
use App\Telegram\ToggleTaskStatus;
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
            $this->getPending($chat_id);
        } elseif (Str::of($message)->startsWith('/logout')) {
            $this->logout($chat_id);
        } elseif (Str::of($message)->startsWith('/start')) {
            $this->start($chat_id);
        } elseif (Str::of($message)->startsWith('/stats')) {
            $this->stats($chat_id);
        } else {
            return $this->send($chat_id, 'Please enter the valid command!');
        }
    }

    public function getPending($chat_id)
    {
        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();
            $tasks = Task::cacheFor(60 * 60)
                ->where([
                    ['user_id', $user->id],
                    ['done', false],
                ])
                ->get();

            if (count($tasks) > 0) {
                if (! $user->hasVerifiedEmail()) {
                    return $this->send($chat_id, '💌 Your email is not *verified*!');
                }

                if ($user->isFlagged) {
                    return $this->send($chat_id, '🚩 Your account is *flagged*!');
                }

                $res = [];
                foreach ($tasks as $task) {
                    array_push($res, '⏳ *'.$task->task.'* [#'.$task->id.'](https://taskord.com/task/'.$task->id.')');
                }

                return $this->send($chat_id, implode("\n\n", $res));
            } else {
                return $this->send($chat_id, '*All done!* No pending tasks 👏');
            }
        }
    }

    public function stats($chat_id)
    {
        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();
            if ($user) {
                $res = "*Your account stats ✨*\n\n"
                       .'🔥 *'.number_format($user->getPoints())."* Reputations\n"
                       .'✅ *'.number_format($user->tasks()->whereDone(true)->count())."* tasks completed\n"
                       .'⏳ *'.number_format($user->tasks()->whereDone(false)->count())."* tasks pending\n"
                       .'📦 *'.number_format($user->ownedProducts()->whereLaunched(true)->count())."* products launched\n"
                       .'📦 *'.number_format($user->ownedProducts()->count())."* products owned\n"
                       .'👥 *'.number_format($user->products()->count())."* products you are member of\n"
                       .'💬 *'.number_format($user->comments()->count())."* comments posted\n"
                       .'❓ *'.number_format($user->questions()->count())."* questions asked\n"
                       .'💬 *'.number_format($user->answers()->count())."* questions answered\n";

                return $this->send($chat_id, $res);
            }
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

    public function logout($chat_id)
    {
        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();
            if ($user) {
                $user->telegram_chat_id = null;
                $user->save();

                return $this->send($chat_id, '🚪 *Logout successful*');
            }
        }
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
