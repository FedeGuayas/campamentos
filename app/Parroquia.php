<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    protected $fillable=[
        'canton_id','code','parroquia',
    ];

    public function canton()
    {
        return $this->belongsTo('App\Canton');
    }
}
