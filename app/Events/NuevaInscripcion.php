<?php

namespace App\Events;

use App\Calendar;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NuevaInscripcion extends Event
{
    use SerializesModels;

    public $calendar;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Calendar $calendar)
    {
        $this->calendar=$calendar;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
