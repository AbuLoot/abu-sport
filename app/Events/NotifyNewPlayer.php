<?php

namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyNewPlayer extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match_id;
    public $count;
    public $user_id;
    public $fullname;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($match_id, $count, $user_id, $fullname)
    {
        $this->match_id = $match_id;
        $this->count = $count + 1;
        $this->user_id = $user_id;
        $this->fullname = $fullname;
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
            'view' => 2,
            'number' => $this->count,
            'userId' => $this->user_id,
            'fullname' => $this->fullname
        ];
    }

    public function broadcastAs()
    {
        return 'NotifyNewPlayer';
    }
}
