<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'descuentos';

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
        'descripcion','valor','factura_id'
    ];

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }
    
}
