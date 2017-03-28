<?php

namespace App\Events;

use Auth;
use App\Chat;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddedNewMessage extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['chat-'.$this->message->match_id];
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->message->user_id,
<<<<<<< HEAD
            'fullname' =>$this->message->user->surname.' '.$this->message->user->name,
            'message' => $this->message->message,
			'match_id' => $this->message->match_id,
=======
            'fullname' => Auth::user()->surname.' '.Auth::user()->name,
            'message' => $this->message->message,
>>>>>>> d17d7416b768cec8a25706a117cbf130d1c8f5ca
            'created_at' => $this->message->created_at
        ];
    }

    public function broadcastAs()
    {
        return 'AddedNewMessage';
    }
}
