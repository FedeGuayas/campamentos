<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    const FACTURAR_A_OTRO = '1';
    const FACTURAR_A_REPRESENTANTE = '0';

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
    protected $table = 'facturas';

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
        'pago_id','representante_id','descuento','total','otro_factura','fact_nombres','fact_ci','fact_email','fact_phone','fact_direccion'
    ];


    public function setFactNombresAttribute($value)
    {
        $this->attributes['fact_nombres']=mb_strtolower($value);
    }

    public function getFactNombresAttribute($value)
    {
        return  mb_strtoupper($value);
    }

    public function setFactEmailAttribute($value)
    {
        $this->attributes['fact_email']=mb_strtolower($value);
    }

    public function setFactDireccionAttribute($value)
    {
        $this->attributes['fact_direccion']=mb_strtolower($value);
    }

    public function getFactDireccionAttribute($value)
    {
        return  mb_strtoupper($value);
    }


    /**
     * True if invoice another people that not parent
     * @return bool
     */
    public function facturaOtro()
    {
        return $this->otro_factura === Factura::FACTURAR_A_OTRO;
    }


    public function representante()
    {
        return $this->belongsTo('App\Representante');
    }

    public function pago()
    {
        return $this->belongsTo('App\Pago');
    }

    public function descuentos()
    {
        return $this->hasOne('App\Descuento');
    }

    public function inscripcions()
    {
        return $this->hasMany('App\Inscripcion');
    }

    public function pago_matricula()
    {
        return $this->hasOne('App\PagoMatricula');
    }
}
