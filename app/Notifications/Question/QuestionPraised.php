<?php

namespace App\Notifications\Question;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $question;
    protected $user_id;

    public function __construct($question, $user_id)
    {
        $this->question = $question;
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
                        ->subject('@'.$user->username.' praised your question')
                        ->greeting('Hello @'.$notifiable->username.' 👋')
                        ->line('👍 Your question was praised by @'.$user->username)
                        ->line($this->question->title)
                        ->action('Go to Question', url('/question/'.$this->question->id))
                        ->line('Thank you for using Taskord!');
        } else {
            return null;
        }
    }

    public function toDatabase($notifiable)
    {
        return [
            'question_id' => $this->question->id,
            'user_id' => $this->user_id,
        ];
    }
}