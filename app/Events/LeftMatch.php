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

class LeftMatch extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match;
<<<<<<< HEAD
	public $user_id;
=======
>>>>>>> d17d7416b768cec8a25706a117cbf130d1c8f5ca

    /**
     * Create a new event instance.
     *
     * @return void
     */
<<<<<<< HEAD
    public function __construct(Match $match, $userid)
    {
        $this->match = $match;
		$this->user_id = $userid;
=======
    public function __construct(Match $match)
    {
        $this->match = $match;
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
<<<<<<< HEAD
            'id' => $this->user_id,
			'matchid'=>$this->match->id,
=======
            'id' => Auth::id(),
>>>>>>> d17d7416b768cec8a25706a117cbf130d1c8f5ca
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
