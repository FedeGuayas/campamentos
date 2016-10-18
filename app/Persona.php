<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombres', 'apellidos', 'tipo_doc', 'num_doc', 'genero', 'fecha_nac', 'email', 'direccion', 'telefono'
    ];

    /**
     * con esta funcion retorno el nombre y los apellidos
     * @return string
     */
    function getNombreAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    /**
     * Calcular edad
     * @param $fecha_nac
     * @return mixed
     */

    public function getEdad($fecha_nac)
    {
        $date = explode('-', $this->$fecha_nac);
        return Carbon::createFromDate($date[0], $date[1], $date[2])->diff(Carbon::now())->format('%y');
        // return Carbon::createFromDate($date[0],$date[1],$date[2])->diff(Carbon::now())->format('%y years %m months %d days');
//        return \Carbon\Carbon::parse($this->fecha_nac)->age;
    }


    public function scopeSearchPersona($query, $search)
    {
            $query->where('num_doc', 'LIKE', '%' . $search . '%')
                ->orWhere('nombres', 'LIKE', '%' . $search . '%')
                ->orWhere('apellidos', 'LIKE', '%' . $search . '%');
        
        return $query;
    }


    public function alumnos()
    {
        return $this->hasMany('App\Alumno');
    }

    public function representantes()
    {
        return $this->hasMany('App\Representante');
    }


}
