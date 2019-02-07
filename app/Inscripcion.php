<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscripcion extends Model
{

    use SoftDeletes;

    const INSCRIPCION_ONLINE='1';
    const INSCRIPCION_PRESENCIAL='0';

    const PAGO_MATRICULA_POSTERIORMENTE='1';

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
        'calendar_id','alumno_id','user_id','factura_id','matricula','mensualidad','cancelado_mensual','escenario_id','inscripcion_type'

    ];

    public function esOnline(){
        return $this->inscripcion_type==Inscripcion::INSCRIPCION_ONLINE;
    }

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

    public function calendar()
    {
        return $this->belongsTo('App\Calendar');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function alumno()
    {
        return $this->belongsTo('App\Alumno');
    }

    public function escenario()
    {
        return $this->belongsTo('App\Escenario');
    }


    public function register()
    {
        return $this->hasOne('App\Register');
    }

    public function pago_matricula()
    {
        return $this->hasOne('App\PagoMatricula');
    }
}
