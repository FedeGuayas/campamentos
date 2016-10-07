<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'horarios';

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
        'disciplina_escenario_id','alumno_id','user_id'
    ];
}
