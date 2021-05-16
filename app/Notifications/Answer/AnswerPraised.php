<?php

namespace App\Notifications\Answer;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnswerPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $answer;
    protected $user_id;

    public function __construct($answer, $user_id)
    {
        $this->answer = $answer;
        $this->user_id = $user_id;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->notifications_email) {
            array_push($pref, 'mail');
        }

        if ($notifiable->notifications_web) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        if (! $user->isFlagged) {
            return (new MailMessage)
                        ->subject('@'.$user->username.' praised your answer')
                        ->greeting('Hello @'.$notifiable->username.' 👋')
                        ->line('👏 Your answer was praised by @'.$user->username)
                        ->line($this->answer->answer)
                        ->line('Thank you for using Taskord!');
        } else {
            return null;
        }
    }

    public function toDatabase($notifiable)
    {
        return [
            'answer_id' => $this->answer->id,
            'user_id' => $this->user_id,
        ];
    }
}
