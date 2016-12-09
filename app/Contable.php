<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contable extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'cta_ingreso','cta_xcobrar','cta_anticipo','actividad'

    ];

}
