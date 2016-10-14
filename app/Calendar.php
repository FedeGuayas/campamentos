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
        'program_id','dia_id','horario_id','cupos','contador','mensualidad','nivel'
        
    ];

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function horarios()
    {
        return $this->hasMany('App\Horario');
    }

    public function dias()
    {
        return $this->hasMany('App\Dia');
    }
}
