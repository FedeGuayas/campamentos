<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uniforme extends Model
{
    const DISPONIBLE='1';
    const AGOTADO='0';

    protected $fillable = [
        'tipo','talla','color','img','stock','status'
    ];

    /**
     * Return true si hay disponible
     * @return bool
     */
    public function hayDisponible(){
        return $this->status == Uniforme::DISPONIBLE;
    }

}
