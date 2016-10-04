<?php

namespace App\Http\Controllers;

use App\Escenario;
use App\Transporte;
use Illuminate\Http\Request;

use App\Http\Requests;

class TransportesController extends Controller
{
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
        $transporte->destino=$request->get('destino');
        $transporte->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_escenario($id)
    {
        
        $transporte=Transporte::findOrFail($id);
        $escenarios=[] + Escenario::lists('escenario', 'id')->all();
        return view('campamentos.transportes.escenario_transporte', compact('transporte','escenarios'));
    }

    public function set_escenario(Request $request)
    {
        $transporte_id=$request->get('transporte_id');
        $transporte=Transporte::find($transporte_id);
        $escenario=$request->get('escenario');
        $precio=$request->get('precio');

        $transporte->escenarios()->attach($escenario,['precio'=>$precio]);
        
        return redirect()->route('admin.transportes.index');
    }
    
}
