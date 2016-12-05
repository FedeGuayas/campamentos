<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = [
        'nombres', 'apellidos', 'num_doc'
    ];

    public function scopeSearchWorker($query, $search)
    {
        $query->where('num_doc','=',$search);

        return $query;
    }
    
}
