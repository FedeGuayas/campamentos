<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'modulos';

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
        'modulo', 'inicio','fin','activated'
    ];

    public function program()
    {
        return $this->belongsTo('App\Program');
    }
}