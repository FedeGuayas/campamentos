<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'calendars';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_id','dia_id','horario_id','cupos','contador','mensualidad','nivel','init_age','end_age'
        
    ];

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function horario()
    {
        return $this->belongsTo('App\Horario');
    }

    public function dia()
    {
        return $this->belongsTo('App\Dia');
    }

    public function inscripcions()
    {
        return $this->hasMany('App\Inscripcion');
    }

    public function profesor()
    {
        return $this->belongsTo('App\Profesor');
    }
}
