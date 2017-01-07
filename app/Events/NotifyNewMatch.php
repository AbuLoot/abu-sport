<?php

namespace App\Events;

use App\Match;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyNewMatch extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match;
    public $sport_slug;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match, $sport_slug)
    {
        $this->match = $match;
        $this->sport_slug = $sport_slug;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['admin-area-'.$this->match->field->area_id];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->match->id,
            'sportSlug' => $this->sport_slug,
            'areaId' => $this->match->field->area_id,
            'fieldId' => $this->match->field_id,
            'userId' => $this->match->user_id,
            'fullName' => $this->match->user->surname.' '.$this->match->user->name,
            'startTime' => $this->match->start_time,
            'endTime' => $this->match->end_time,
            'date' => $this->match->date,
            'price' => $this->match->price,
            'matchType' => $this->match->match_type,
            'numberOfPlayers' => $this->match->number_of_players,
            'status' => $this->match->status,
        ];
    }

    public function broadcastAs()
    {
        return 'NotifyNewMatch';
    }
}
