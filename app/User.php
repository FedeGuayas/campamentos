<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Hash;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes; //borrado seguro
   
    ///Use el trai de entrust asi xk tiene conflicto con SofDeleted
    use EntrustUserTrait {
        SoftDeletes::restore as sfRestore;
        EntrustUserTrait::restore as euRestore;
    }

    //Sobrescribiendo el metodo restor en SofDelete y en EntrustUserTrait para evitar los conflictos
    public function restore() {
        $this->sfRestore();
        Cache::tags(Config::get('entrust.role_user_table'))->flush();
    }


    public $timestamps=true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','pto_cobro'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //setear el password, ya no es necesario encriptar pass en controlador
    public function setPasswordAttribute($value){
        if (!empty ($value)){
            $this->attributes['password'] =bcrypt($value);
        }
    }

    //con esta funcion retorno el nombre y los apellidos en el atributo name k utiliso en el app.blade.php
    function getNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }

    //establecemos las relaciones con el modelo Role, ya que un usuario puede tener varios roles
    //y un rol lo pueden tener varios usuarios
//    public function roles(){
//        return $this->belongsToMany('App\Role');
//    }

    public function inscripcion()
    {
        return $this->belongsTo('App\Inscripcion');
    }

    public function escenario()
    {
        return $this->belongsTo('App\Escenario');
    }

    public function representantes()
    {
        return $this->hasMany('App\Representante');
    }

    public function pago_matriculas()
    {
        return $this->hasMany('App\PagoMatricula');
    }
}
