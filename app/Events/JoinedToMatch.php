<?php

namespace App\Events;

<<<<<<< HEAD
=======
use Auth;
>>>>>>> d17d7416b768cec8a25706a117cbf130d1c8f5ca

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
<<<<<<< HEAD
    public function __construct(Match $match, $userid)
    {
        $this->match = $match;
        $this->user = $match->users()->wherePivot('user_id', $userid)->first();
=======
    public function __construct(Match $match)
    {
        $this->match = $match;
        $this->user = $match->users()->wherePivot('user_id', Auth::id())->first();
>>>>>>> d17d7416b768cec8a25706a117cbf130d1c8f5ca
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
<<<<<<< HEAD
			'matchid' => $this->match->id,
            'fullName' => $this->user->surname.' '.$this->user->name,
            'balance' => $this->user->balance,
			'phone' => $this->user->phone,
			'email' => $this->user->email,
=======
            'fullName' => $this->user->surname.' '.$this->user->name,
            'balance' => $this->user->balance,
>>>>>>> d17d7416b768cec8a25706a117cbf130d1c8f5ca
            'usersCount' => 1 + $this->match->users->count(),
            'status' => 1
        ];
    }

    public function broadcastAs()
    {
        return 'JoinedToMatch';
    }
}
