<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserFollowed extends Notification
{
    use Queueable;

    protected $follower;


    public function __construct($follower)
    {
        $this->follower = $follower;
    }


    public function via(object $notifiable): array
    {
        return ['mail', 'broadcast'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting(__('notifications.hello', ['username' => $notifiable->username]))
            ->line(__('notifications.user_followed', ['follower' => $this->follower->username]))
            ->action(__('notifications.view_profile'), url('/profile/' . $this->follower->id))
            ->line(__('notifications.thank_you'));
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => __('notifications.user_followed', ['follower' => $this->follower->username]),
        ]);
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
