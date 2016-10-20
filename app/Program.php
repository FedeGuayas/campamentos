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
    
    public function escenarios(){
       return $this->hasMany('App\Escenario');
    }

    public function disciplinas(){
        return $this->hasMany('App\Disciplina');
    }

    public function modulos(){
        return $this->hasMany('App\Modulo');
    }

    public function calendar()
    {
        return $this->belongsTo('App\Calendar');
    }

}
