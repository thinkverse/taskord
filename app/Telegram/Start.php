<?php

namespace App\Telegram;

use Telegram;

class Start
{
    protected $chatId;

    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    public function __invoke()
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

        return $this->send($this->chatId, $res);
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
