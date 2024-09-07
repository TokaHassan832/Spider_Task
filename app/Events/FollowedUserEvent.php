<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FollowedUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $follower;
    public function __construct($follower)
    {
        $this->follower = $follower;
    }


    public function broadcastOn(): array
    {
        return [
            new Channel('user-followed'),
        ];
    }

    public function broadcastWith()
    {
        return ['message' => "{$this->follower} has followed you!"];
    }
}
