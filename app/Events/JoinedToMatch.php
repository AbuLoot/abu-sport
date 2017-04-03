<?php

namespace App\Events;


use App\Match;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JoinedToMatch extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $match;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match, $user_id)
    {
        $this->match = $match;
        $this->user = $match->users()->wherePivot('user_id', $user_id)->first();
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
            'id' => $this->user->id,
			'matchid' => $this->match->id,
            'fullName' => $this->user->surname.' '.$this->user->name,
            'balance' => $this->user->balance,
			'phone' => $this->user->phone,
			'email' => $this->user->email,
            'usersCount' => 1 + $this->match->users->count(),
            'status' => 1
        ];
    }

    public function broadcastAs()
    {
        return 'JoinedToMatch';
    }
}
