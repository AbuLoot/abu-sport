<?php

namespace App\Events;

use App\Match;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreatedNewMatch extends Event implements ShouldBroadcast
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
        return [
            'area-'.$this->match->field->area_id,
            'area-'.$this->match->field->area_id.'_date-'.$this->match->date
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->match->id,
            'sportSlug' => $this->sport_slug,
            'fieldId' => $this->match->field_id,
            'userId' => $this->match->user_id,
            'startTime' => $this->match->start_time,
            'endTime' => $this->match->end_time,
            'date' => $this->match->date,
            'price' => $this->match->price,
            'matchType' => $this->match->match_type,
			'gameType' => $this->match->game_type,
			'gameFormat' => $this->match->game_format,
            'usersCount' => 1 + $this->match->users->count(),
            'numberOfPlayers' => $this->match->number_of_players,
            'status' => $this->match->status,
        ];
    }

    public function broadcastAs()
    {
        return 'CreatedNewMatch';
    }
}
