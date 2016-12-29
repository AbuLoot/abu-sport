<?php

namespace App\Events;

use Auth;

use App\Match;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LeftMatch extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match)
    {
        $this->match = $match;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['match-'.$this->match->id];
    }

    public function broadcastWith()
    {
        return [
            'id' => Auth::id(),
            'usersCount' => 1 + $this->match->users->count(),
            'csrf' => csrf_token(),
            'status' => 0
        ];
    }

    public function broadcastAs()
    {
        return 'LeftMatch';
    }
}
