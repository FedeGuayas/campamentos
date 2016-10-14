<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'horarios';

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
        'start_time', 'end_time','activated'
    ];

    public function calendar()
    {
        return $this->belongsTo('App\Calendar');
    }
    
}
