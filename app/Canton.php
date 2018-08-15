<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    protected $fillable=[
        'province_id','code','canton',
    ];

    public function provincia()
    {
        return $this->belongsTo('App\Provincia','province_id');
    }

    public function parroquias()
    {
        return $this->hasMany('App\Parroquia');
    }
}
