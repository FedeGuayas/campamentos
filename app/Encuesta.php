<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $fillable = [
        'encuesta',
        'contador',
    ];
    
    public function representantes()
    {
        $this->hasMany('App\Representante');
    }
}
