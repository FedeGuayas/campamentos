<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscripcion extends Model
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

    protected $table = 'inscripcions';

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
        'calendar_id','alumno_id','user_id','factura_id','matricula','mensualidad'

    ];

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

    public function calendars()
    {
        $this->hasMany('App\Program');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function alumnos()
    {
        $this->hasMany('App\Alumno');
    }
}
