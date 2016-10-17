<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representante extends Model
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
    protected $table = 'representantes';

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
        'persona_id','encuesta_id','foto_ced','foto','phone'
    ];

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

    public function persona(){
        return $this->belongsTo('App\Persona');
    }
    
    public function alumnos()
    {
        return $this->hasMany('App\Alumno');
    }
    
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta');
    }
    
    
}
