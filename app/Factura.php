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
        'pago_id','representante_id','num_fact','descuento','total'
    ];

    public function representante()
    {
        return $this->belongsTo('App\Representante');
    }

    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }

    public function descuento()
    {
        return $this->belongsTo('App\Descuento');
    }

    public function inscripcion()
    {
        return $this->belongsTo('App\Inscripcion');
    }
}
