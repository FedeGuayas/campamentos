<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'programs';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'escenario_id','disciplina_id','modulo_id','matricula','cuposT','activated'
    ];
    
    public function escenario(){
       return $this->belongsTo('App\Escenario');
    }

    public function disciplina(){
        return $this->belongsTo('App\Disciplina');
    }

    public function modulo(){
        return $this->belongsTo('App\Modulo');
    }

    public function calendars()
    {
        return $this->hasMany('App\Calendar');
    }
    
}
