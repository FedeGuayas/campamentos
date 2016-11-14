<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'disciplinas';

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
        'disciplina','activated'
    ];
    
    public function programs()
    {
        return $this->hasMany('App\Program');
    }
}
