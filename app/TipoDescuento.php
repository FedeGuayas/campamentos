<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDescuento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'porciento', 'multiplicador', 'descripcion'
    ];

    protected $table = 'tipo_descuentos';

    protected $dates = ['deleted_at'];

    public function setNombreAttribute($nombre){
        $this->attributes['nombre'] = mb_strtoupper($nombre);
    }

    public function setMultiplicadorAttribute($porciento){
        if (!empty ($porciento) && ( $porciento>=0 && $porciento<=100 ) ){
            $this->attributes['multiplicador'] = ($porciento/100);
        }
    }

    public function getMultiplicadorAttribute(){

           return (float)$this->attributes['multiplicador'];

    }

    public function setDescripcionAttribute($descripcion){
        $this->attributes['descripcion'] = mb_strtoupper($descripcion);

    }


}
