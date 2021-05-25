<?php

namespace App\Telegram;

use App\Models\User;
use Telegram;

class AuthUser
{
    protected $token;
    protected $chatId;

    public function __construct(
        $token,
        $chatId
    ) {
        $this->token = $token;
        $this->chatId = $chatId;
    }

    public function __invoke()
    {
        $user = User::whereApiToken($this->token)->first();
        $userCount = User::whereTelegramChatId($this->chatId)->count('id');
        if (! $user or strlen($this->token) !== 60) {
            $helper = "Go to https://taskord.com/settings/api and copy your *API Token 🔑*\n\n"
                .'And paste it here `/auth <API token>`';

            return $this->send($this->chatId, $helper);
        }

        if ($userCount > 1) {
            return $this->send($this->chatId, '*This Telegram account is already associated with another account* 👀');
        }

        if ($user->telegram_chat_id) {
            return $this->send($user->telegram_chat_id, '*You are already authenticated* ✅');
        } else {
            $user->telegram_chat_id = $this->chatId;
            $user->save();

            return $this->send($user->telegram_chat_id, '*Authentication successful* ✅');
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
