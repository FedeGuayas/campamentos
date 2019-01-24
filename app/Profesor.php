<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    const ACTIVO='1';
    const INACTIVO='0';

    public $timestamps = false;
    
    protected $fillable = [
        'nombres', 'apellidos', 'num_doc'
    ];

    function getNameAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function calendars()
    {
        return $this->hasMany('App\Calendar');
    }
}
