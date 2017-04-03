<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyLeftPlayer extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match_id;
    public $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($match_id, $user_id)
    {
        $this->match_id = $match_id;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['chat-'.$this->match_id];
    }

    public function broadcastWith()
    {
        return [
            'view' => 3,
            'userId' => $this->user_id
        ];
    }

    public function broadcastAs()
    {
        return 'NotifyLeftPlayer';
    }
}
