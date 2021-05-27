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
            $chatId = $response['from']['id'];
            if (
                isset($response['document']) or // Avoid Document
                isset($response['sticker']) or // Avoid Sticker
                isset($response['poll']) or // Avoid Polls
                isset($response['location']) or // Avoid location
                isset($response['contact']) or // Avoid contact
                isset($response['forward_from']) // Avoid forwards
            ) {
                return $this->send($chatId, '⚠ *Oops! Not allowed!*');
            } elseif (isset($response['photo'])) {
                $message = isset($response['caption']) ? $response['caption'] : '/start';
                $fileId = $response['photo'][1]['file_id'];
            } else {
                $message = $response['text'];
                $fileId = null;
            }
        } else {
            return false;
        }

        return $this->command($chatId, $message, $fileId);
    }

    public function command($chatId, $message, $fileId)
    {
        $user = User::whereTelegramChatId($chatId)->first();

        switch (true) {
            case Str::of($message)->startsWith('/start'):
                return (new Start($chatId))();
            break;

            case Str::of($message)->startsWith('/auth'):
                $token = substr($message, strpos($message, '/auth') + 6);

                return (new AuthUser($token, $chatId))();
            break;

            case Str::of($message)->startsWith('/todo'):
                if ($this->authCheck($chatId)) {
                    $task = substr($message, strpos($message, '/todo') + 6);

                    return (new CreateTask($user, $task, false))();
                }
            break;

            case Str::of($message)->startsWith('/done'):
                if ($this->authCheck($chatId)) {
                    $task = substr($message, strpos($message, '/done') + 6);

                    return (new CreateTask($user, $task, $fileId, true))();
                }
            break;

            case Str::of($message)->startsWith('/complete'):
                if ($this->authCheck($chatId)) {
                    $messageId = substr($message, strpos($message, '/complete') + 10);

                    return (new ToggleTaskStatus($user, $messageId, true))();
                }
            break;

            case Str::of($message)->startsWith('/uncomplete'):
                if ($this->authCheck($chatId)) {
                    $messageId = substr($message, strpos($message, '/complete') + 12);

                    return (new ToggleTaskStatus($user, $messageId, false))();
                }
            break;

            case Str::of($message)->startsWith('/pending'):
                if ($this->authCheck($chatId)) {
                    return (new Pending($user))();
                }
            break;

            case Str::of($message)->startsWith('/stats'):
                if ($this->authCheck($chatId)) {
                    return (new Stats($user))();
                }
            break;

            case Str::of($message)->startsWith('/logout'):
                if ($this->authCheck($chatId)) {
                    return (new Logout($chatId))();
                }
            break;

            default:
                return $this->send($chatId, 'Please enter the valid command!');
            break;
        }
    }

    public function authCheck($chatId)
    {
        $user = User::whereTelegramChatId($chatId)->first();
        if ($user) {
            return true;
        } else {
            $this->send($chatId, '🔒 *You\'re not logged in. /auth <token> to begin*');

            return false;
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
