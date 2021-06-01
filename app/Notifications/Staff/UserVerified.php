<?php

namespace App\Notifications\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserVerified extends Notification implements ShouldQueue
{
    use Queueable;

    public function via()
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Your account has been verified ✅')
            ->greeting('Hello @'.$notifiable->username.' 👋')
            ->line('Your account has been verified in Taskord 🎉')
            ->line('Thank you for using Taskord!');
    }
}
