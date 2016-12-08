<?php

namespace App;

use Carbon\Carbon;
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

    public $timestamps = true;

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

    public function getEdad($fecha_nac)
    {        $date = explode('-', $fecha_nac);
        return Carbon::createFromDate($date[0], $date[1], $date[2])->diff(Carbon::now())->format('%y');

    }
    
}
