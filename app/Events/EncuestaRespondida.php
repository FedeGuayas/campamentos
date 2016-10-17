<?php

namespace App\Events;

use App\Encuesta;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EncuestaRespondida extends Event
{
    use SerializesModels;


    public $encuesta;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Encuesta $encuesta)
    {
        $this->encuesta=$encuesta;
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
