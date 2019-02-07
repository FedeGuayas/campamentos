<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
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
        'pago_id','representante_id','descuento','total'
    ];

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
