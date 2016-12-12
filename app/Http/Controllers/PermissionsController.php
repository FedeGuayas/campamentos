<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use Illuminate\Support\Facades\Redirect;
use Session;

use App\Http\Requests;



class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:administrator']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        if ($request){
            $permisos=Permission::all();
//        }

        return view('campamentos.permissions.index', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permiso=new Permission;
        $permiso->name=$request->get('name');
        $permiso->display_name=$request->get('display_name');
        $permiso->description=$request->get('description');
        $permiso->save();

        Session::flash('message', 'Permiso creado correctamente');
        return Redirect::to('admin/permissions') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $per=Permission::findOrFail($id);
        return view('campamentos.permissions.show',compact('per'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permiso=Permission::findOrFail($id);
        return view('campamentos.permissions.edit',compact('permiso'));
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
        $permiso=Permission::findOrFail($id);
        $permiso->update($request->all());

        Session::flash('message','Permiso actualizado');
        return Redirect::to('admin/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permiso=Permission::findOrFail($id);
        $permiso->delete;

        Session::flash('message','Permiso eliminado');
        return Redirect::to('admin/permissions');
    }
}
