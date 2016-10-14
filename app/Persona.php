<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use SoftDeletes;

    public $timestamps=true;
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
        'nombres', 'apellidos', 'tipo_doc', 'num_doc','genero', 'fecha_nac','email','direccion','telefono'        
    ];

    //con esta funcion retorno el nombre y los apellidos 
    function getNombreAttribute(){
        return $this->nombres . ' ' . $this->apellidos;
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
