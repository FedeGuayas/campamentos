<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escenario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'escenarios';

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
        'escenario'
    ];

    public function transportes()
    {
        return $this->belongsToMany('App\Transporte')->withPivot('precio');
    }
}