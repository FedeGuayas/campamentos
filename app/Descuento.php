<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descuento extends Model
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
        'descripcion','valor','factura_id','tipo_descuento_id'
    ];

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

    public function tipo_descuento()
    {
        return $this->belongsTo('App\TipoDescuento');
    }

    //como persona_id es unica pero puede ser null
    public function setTipoDescuentoIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['tipo_descuento_id'] = NULL;
        } else {
            $this->attributes['tipo_descuento_id'] = $value;
        }
    }
    
}
