<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'transportes';

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
        'destino'
    ];

    public function escenarios()
    {
        return $this->belongsToMany('App\Escenario')->withPivot('precio');
    }

}
