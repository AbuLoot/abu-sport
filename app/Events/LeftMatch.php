<?php

namespace App\Events;

use App\Match;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LeftMatch extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match;
	public $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match, $userid)
    {
        $this->match = $match;
		$this->user_id = $userid;
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
            'id' => $this->user_id,
			'matchid'=>$this->match->id,
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
