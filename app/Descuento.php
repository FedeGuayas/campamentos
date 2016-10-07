<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'descuentos';

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
        'tipo','valor'
    ];
}
