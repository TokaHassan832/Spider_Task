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
            ->greeting('Hello ' . $notifiable->username . '!')
            ->line($this->follower->username . ' has followed you.')
            ->action('View Profile', url('/profile/' . $this->follower->id))
            ->line('Thank you for using our application!');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->follower->username . ' has followed you!',
        ]);
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
