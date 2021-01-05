<?php

namespace App\Http\Controllers;

use Telegram;
use App\Models\User;
use Illuminate\Support\Str;

class TelegramController extends Controller
{
    public function getUpdates() {
        $updates = Telegram::getWebhookUpdates();
        $message = $updates->message->text;
        
        if (Str::contains($message, '/pair')) {
            error_log('pair');
        } else {
            error_log('wrong command');
        }
    }
    
    public function authUser($token = 'x0M0PzA0s5zvolvPqTIgOcCmcmpODRJpkKYUlh2uI31JZPTHgxTkUabFV0H4') {
        $user = User::where('api_token', $token)->first();
        if (! $user) {
            return dd('get away');
        }
        
        if ($user->telegram_chat_id) {
            dd('you already have one');
        } else {
            $user->telegram_chat_id = '1084454902';
            $user->save();
            Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'You have been authenticated!'
            ]);
        }
    }
}
