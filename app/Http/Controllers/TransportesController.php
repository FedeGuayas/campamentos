<?php

namespace App\Http\Controllers;

use App\Escenario;
use App\Transporte;
use Illuminate\Http\Request;

use Session;
use App\Http\Requests;


class TransportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:administrator'],['except'=>['index']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transportes=Transporte::all();
        return view('campamentos.transportes.index',compact('transportes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.transportes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transporte=new Transporte;
        $transporte->destino=strtoupper($request->get('destino'));
        $transporte->save();

        Session::flash('message','Transporte creado correctamente');
        return redirect()->route('admin.transportes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transporte=Transporte::findOrFail($id);
        return view('campamentos.transportes.show',compact('transporte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transporte=Transporte::findOrFail($id);
        return view('campamentos.transportes.edit',compact('transporte'));
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
        $trasnporte=Transporte::findOrFail($id);
        $trasnporte->update($request->all());

        Session::flash('message','Transporte actualizado correctamente');
        return redirect()->route('admin.transportes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transporte=Transporte::findOrFail($id);
        $transporte->delete();

        Session::flash('message','Transporte eliminado correctamente');
        return back();
    }

    /**
     * Muestra el formulario para asignar los precios y origenes a este destino
     * @param $id identificador del dstino del transporte
     * @return mixed
     */
    public function get_escenario($id)
    {
        $transporte=Transporte::findOrFail($id);
        $escenarios=[] + Escenario::lists('escenario', 'id')->all();
        return view('campamentos.transportes.transporte_escenarioCreate', compact('transporte','escenarios'));
    }

    /**
     * Almacena la relacion Many to Many del escenario y el transporte con su precio
     * @param Request $request
     * @return mixed
     */
    public function set_escenario(Request $request)
    {
        $transporte_id=$request->get('transporte_id');
        $transporte=Transporte::find($transporte_id);
        $escenario_id=$request->get('escenario');
        $escenario=Escenario::findOrFail($escenario_id);
        $precio=$request->get('precio');
        $transporte->escenarios()->attach($escenario_id,['precio'=>$precio]);

        Session::flash('message','Se agregó "'.$escenario->escenario.'" al "'.$transporte->destino.'", con un costo de $'.$precio.'');
        return redirect()->route('admin.transportes.index');
    }

    /**
     * Eliminar un origen (escenario_id) del destino (transporte_id)
     * @param $transporte_id
     * @param $escenario_id
     * @return mixed
     */
    public function destroyEscenario($transporte_id,$escenario_id)
    {
        $transporte=Transporte::findOrFail($transporte_id);
        $transporte->escenarios()->detach($escenario_id);

        Session::flash('message','Origen eliminado correctamente');
        return back();
    }

    

    
}
