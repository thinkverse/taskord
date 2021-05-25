<?php

namespace App\Telegram;

use App\Models\User;
use Telegram;

class Logout
{
    protected $chatId;

    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    public function __invoke()
    {
        $user = User::whereTelegramChatId($this->chatId)->first();
        if ($user) {
            $user->telegram_chat_id = null;
            $user->save();

            return $this->send($this->chatId, '🚪 *Logout successful*');
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
