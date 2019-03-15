<?php

namespace App\Http\Controllers;

use App\Escenario;
use App\Modulo;
use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class ModulosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:planner|administrator'],['except'=>['index']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulos=Modulo::all()->sortBy('inicio');
        return view('campamentos.modulos.index',compact('modulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.modulos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $river=$request->modulo_river;

        if ( $river=='on' ){
            $modulo_river = Modulo::ES_RIVER;
        }else {
            $modulo_river = Modulo::NO_RIVER;
        }

//        $inicio = Carbon::createFromFormat('Y-m-d', $request->get('inicio'));
        $inicio = $request->get('inicio');
        $fin = $request->get('fin');

//dd($inicio);
        $modulo=new Modulo();
        $modulo->modulo=strtoupper($request->get('modulo'));
        $modulo->inicio=$inicio;
        $modulo->fin=$fin;
        $modulo->modulo_river=$modulo_river;

        $modulo->save();
        Session::flash('message','Modulo creado correctamente');
        return redirect()->route('admin.modulos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modulo=Modulo::findOrFail($id);
        return view('campamentos.modulos.edit',compact('modulo'));
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
        $river=$request->modulo_river;

        if ( $river=='on' ){
            $modulo_river = Modulo::ES_RIVER;
        }else {
            $modulo_river = Modulo::NO_RIVER;
        }

        $modulo=Modulo::findOrFail($id);
        $modulo->modulo=strtoupper($request->get('modulo'));
        $modulo->inicio=$request->get('inicio');
        $modulo->fin=$request->get('fin');
        $modulo->modulo_river=$modulo_river;
        $modulo->update();

        Session::flash('message','Modulo actualizado correctamente');
        return redirect()->route('admin.modulos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modulo=Modulo::findOrFail($id);
        $programs=Program::where('modulo_id',$id)->first();
        if ($programs){
            Session::flash('message_danger', 'No es posible eliminar el módulo "'.$modulo->modulo.'" porque tiene programas asignados');
            return redirect()->back();
        }
        $modulo->delete();
        Session::flash('message', 'Módulo eliminado');
        return redirect()->route('admin.modulos.index');
    }
   
    public function disable($id)
    {
        $modulo=Modulo::findOrFail($id);
        $modulo->activated=false;
        $modulo->update();
        return back();
    }

    public function enable($id)
    {
        $modulo=Modulo::findOrFail($id);
        $modulo->activated=true;
        $modulo->update();
        return back();
    }
       
    
}
