<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Modulo extends Model
{

    const ES_RIVER='1';
    const NO_RIVER='0';

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $dates=['inicio','fin'];

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
        'modulo','modulo_river','inicio','fin','activated'
    ];

    /**
     * Return true si es un modulo river
     * @return bool
     */
    public function esRiver(){
        return $this->modulo_river == Modulo::ES_RIVER;
    }

    //Buscar por mes
    public function scopeSearchMonthBetwen($query, $search)
    {
        $query->whereBetween($search, ['inicio', 'fin'])->get();
        return $query;
    }

    /**
     * Relaciones
     */

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

}
