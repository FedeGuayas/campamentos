<?php
/**
 * para guardar en una tabla (registers) el numero de las inscripciones
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = [
        'num_registro'

    ];

    public function inscripcion()
    {
        return $this->belongsTo('App\Inscripcion');
    }

    public function getMaxNumRegistroAttribute($value)
    {
        return $this->num_registro->incremet();
    }
}
