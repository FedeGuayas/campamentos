<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'disciplinas';

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
        'disciplina'
    ];
    
    public function escenarios()
    {
        return $this->belongsToMany('App\Escenario')->withPivot('horario_id','dia_id','modulo_id','mensualidad','matricula','descuento','cupos');
    }
}
