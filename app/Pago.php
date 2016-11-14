<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'pagos';

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
        'forma','descripcion'
    ];

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
}
