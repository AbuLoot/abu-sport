<?php

namespace App\Events;

use App\User;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyNewPlayer extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match_id;
    public $fullname;
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($match_id, $count, $fullname)
    {
        $this->match_id = $match_id;
        $this->fullname = $fullname;
        $this->count = $count + 1;
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
            'fullname' => $this->fullname
        ];
    }

    public function broadcastAs()
    {
        return 'NotifyNewPlayer';
    }
}
