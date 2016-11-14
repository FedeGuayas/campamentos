<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Alumno extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnos';

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
        'persona_id','representante_id','discapacitado','foto_ced','foto'
    ];

    public function persona(){
        return $this->belongsTo('App\Persona');
    }

    public function representante(){
        return $this->belongsTo('App\Representante');
    }

    public function inscripcions(){
        return $this->hasMany('App\Inscripcion');
    }
}
