<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Hash;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait; // add this trait to your user model

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //setear el password, ya no es necesario encriptar pass en controlador
    public function setPasswordAttribute($value){
        if (!empty ($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    //con esta funcion retorno el nombre y los apellidos en el atributo name k utiliso en el app.blade.php
    function getNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }

    //establecemos las relaciones con el modelo Role, ya que un usuario puede tener varios roles
    //y un rol lo pueden tener varios usuarios
    public function roles(){
        return $this->belongsToMany('App\Role');
    }
}
