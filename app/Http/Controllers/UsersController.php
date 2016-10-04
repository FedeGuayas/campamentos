<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Http\Request;

use App\Http\Requests;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $usuarios=User::all();

        }

        return view('campamentos.users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('campamentos.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=new User;
        $user->first_name=$request->get('first_name');
        $user->last_name=$request->get('last_name');
        $user->email=$request->get('email');
        $user->password=$request->get('password');
        $user->activated='1';
        $user->save();

        Session::flash('message', 'Usuario creado correctamente');
        return Redirect::to('admin/users') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::findOrFail($id);
        return view('campamentos.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        return view('campamentos.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $user->update($request->all());
        $nombre=User::findOrFail($id)->getNameAttribute();
      
        Session::flash('message','Se actualizo el usuario '.$nombre);
        return Redirect::to('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();

        Session::flash('message','Usuario eliminado');
        return Redirect::to('admin/users');
    }

    /**
     * Muestra la vista con los roles que se pueden aplicar al usuario.
     *
     * $id de usuario
     * 
     */
    public  function roles($id)
    {
        $user=User::findOrFail($id);
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        $roles=Role::all();
        return view('campamentos.users.roles',compact('user','roles'));
    }

    /**
     * Addiconar o kitar los roles del usuario.
     *
     * $id de usuario
     *
     */    
    public  function setRoles(Request $request)
    {
        $user_id=$request->get('user_id');
        $user=User::findOrFail($user_id);
        $roles=$request->get('roles');
        
        if ($roles) {
            // El usuario marcó checkbox
            foreach ($roles as $rol){
                $user->attachRole($rol);
            }

        } else {
            // El usuario no marcó checkbox
                $user->detachRole($roles);
     }
        return Redirect::to('admin/users');
    }


    /**
     * Mostrar el perfi de usuario
     */
    public function showProfile()
    {
        $user=Auth::user();
        return view('campamentos.users.profile', compact('user'));
    }
    
}
