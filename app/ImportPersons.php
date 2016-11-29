<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportPersons extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'persons';
    
    protected $fillable = [
        'calendar_id','alumno_id','user_id','factura_id','matricula','mensualidad'

    ];
}
