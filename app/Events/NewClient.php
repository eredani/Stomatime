<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewClient implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  
    public $user;
    public function __construct()
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('newclient');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email
        ];
    }
}
