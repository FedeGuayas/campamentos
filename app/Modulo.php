<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function programs()
    {
        return $this->hasMany('App\Program');
    }


    //Buscar por mes
    public function scopeSearchMonthBetwen($query, $search)
    {
        $query->whereBetween($search, ['inicio', 'fin'])->get();
        return $query;
    }





}
