<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Telegram\AuthUser;
use App\Telegram\CreateTask;
use App\Telegram\Logout;
use App\Telegram\Pending;
use App\Telegram\Start;
use App\Telegram\Stats;
use App\Telegram\ToggleTaskStatus;
use Illuminate\Support\Str;
use Telegram;

class TelegramController extends Controller
{
    public function getUpdates()
    {
        $updates = Telegram::getWebhookUpdates();
        $response = $updates->message;
        if (isset($response['message_id'])) {
            $chat_id = $response['from']['id'];
            if (
                isset($response['document']) or // Avoid Document
                isset($response['sticker']) or // Avoid Sticker
                isset($response['poll']) or // Avoid Polls
                isset($response['location']) or // Avoid location
                isset($response['contact']) or // Avoid contact
                isset($response['forward_from']) // Avoid forwards
            ) {
                return $this->send($chat_id, '⚠ *Oops! Not allowed!*');
            } elseif (isset($response['photo'])) {
                $message = isset($response['caption']) ? $response['caption'] : '/start';
                $file_id = $response['photo'][1]['file_id'];
            } else {
                $message = $response['text'];
                $file_id = null;
            }
        } else {
            return false;
        }

        return $this->command($chat_id, $message, $file_id);
    }

    public function command($chat_id, $message, $file_id)
    {
        $user = User::where('telegram_chat_id', $chat_id)->first();

        switch (true) {
            case Str::of($message)->startsWith('/start'):
                return (new Start($chat_id))();
            break;

            case Str::of($message)->startsWith('/auth'):
                $token = substr($message, strpos($message, '/auth') + 6);

                return (new AuthUser($token, $chat_id))();
            break;

            case Str::of($message)->startsWith('/todo'):
                if ($this->authCheck($chat_id)) {
                    $task = substr($message, strpos($message, '/todo') + 6);

                    return (new CreateTask($user, $task, false))();
                }
            break;

            case Str::of($message)->startsWith('/done'):
                if ($this->authCheck($chat_id)) {
                    $task = substr($message, strpos($message, '/done') + 6);

                    return (new CreateTask($user, $task, $file_id, true))();
                }
            break;

            case Str::of($message)->startsWith('/complete'):
                if ($this->authCheck($chat_id)) {
                    $id = substr($message, strpos($message, '/complete') + 10);

                    return (new ToggleTaskStatus($user, $id, true))();
                }
            break;

            case Str::of($message)->startsWith('/uncomplete'):
                if ($this->authCheck($chat_id)) {
                    $id = substr($message, strpos($message, '/complete') + 12);

                    return (new ToggleTaskStatus($user, $id, false))();
                }
            break;

            case Str::of($message)->startsWith('/pending'):
                if ($this->authCheck($chat_id)) {
                    return (new Pending($user))();
                }
            break;

            case Str::of($message)->startsWith('/stats'):
                if ($this->authCheck($chat_id)) {
                    return (new Stats($user))();
                }
            break;

            case Str::of($message)->startsWith('/logout'):
                if ($this->authCheck($chat_id)) {
                    return (new Logout($chat_id))();
                }
            break;

            default:
                return $this->send($chat_id, 'Please enter the valid command!');
            break;
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
