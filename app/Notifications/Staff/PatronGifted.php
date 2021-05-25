<?php

namespace App\Notifications\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatronGifted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('You\'ve been gifted with a patron account 🎉')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('Your account was gifted with a patron account by one of the staff members 🎉')
                    ->line('You can see the patron badge everywhere next to your name.')
                    ->line('Thank you for using Taskord!');
    }
}
