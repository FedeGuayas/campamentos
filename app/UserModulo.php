<?php
/**
 * Modelo para guardar los inscritos en modulos de RIVER
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModulo extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'modulo_id', 'anio'
    ];


}
