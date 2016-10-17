<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'dias';

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
        'dia','activated'
    ];

    public function calendar()
    {
        return $this->belongsTo('App\Calendar');
    }
}