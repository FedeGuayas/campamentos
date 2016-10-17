<?php

namespace App\Listeners;

use App\Encuesta;
use App\Events\EncuestaRespondida;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class AumentarContadorEncuesta
{
   

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  EncuestaRespondida  $event
     * @return void
     */
    public function handle(EncuestaRespondida $event)
    {
        $event->encuesta->increment('contador');
        $event->encuesta->update();

//        dd();

    }
}
