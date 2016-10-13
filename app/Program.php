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

    protected $table = 'disciplina_escenario';

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
        'escenario_id','disciplina_id','horario_id','dia_id','modulo_id','mensualidad','matricula','contador','cupos','nivel','activated'
    ];
    
//    public function horario(){
//        $this->belongsTo('App\Horario');
//    }
}
