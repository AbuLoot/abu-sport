<?php

namespace App\Events;

use Auth;

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
    public function __construct(Match $match)
    {
        $this->match = $match;
        $this->user = $match->users()->wherePivot('user_id', Auth::id())->first();
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
            'fullName' => $this->user->surname.' '.$this->user->name,
            'balance' => $this->user->balance,
            'usersCount' => 1 + $this->match->users->count(),
            'status' => 1
        ];
    }

    public function broadcastAs()
    {
        return 'JoinedToMatch';
    }
}
