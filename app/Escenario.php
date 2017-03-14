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
        'escenario','activated'
    ];

    public function transportes()
    {
        return $this->belongsToMany('App\Transporte')->withPivot('precio');
    }

     public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function inscripcions()
    {
        return $this->hasMany('App\Inscripcion');
    }
    
}
