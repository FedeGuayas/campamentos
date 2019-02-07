<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoMatricula extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable=[
        'inscripcion_id', 'user_id', 'user_delete', 'escenario_id', 'factura_id', 'matricula', 'anio'
    ];

    public function inscripcion()
    {
        return $this->belongsTo('App\Inscripcion');
    }

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function escenario()
    {
        return $this->belongsTo('App\Escenario');
    }

}
