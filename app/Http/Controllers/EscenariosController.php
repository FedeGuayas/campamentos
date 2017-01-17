<?php

namespace App\Http\Controllers;

use App\Escenario;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests\EscenariosStoreRequest;
use App\Http\Requests;

class EscenariosController extends Controller
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
    public function index(Request $request)
    {
        $escenarios=Escenario::all();
        return view('campamentos.escenarios.index',compact('escenarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.escenarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EscenariosStoreRequest $request)
    {
        $escenario= new Escenario;
        $escenario->escenario=strtoupper($request->get('escenario'));
        $escenario->save();

        Session::flash('message','Escenario creado correctamente');
        return redirect()->route('admin.escenarios.index');
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
        $escenario=Escenario::findOrFail($id);
        return view('campamentos.escenarios.edit',compact('escenario'));
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
        $escenario=Escenario::findOrFail($id);
        $escenario->update($request->all());

        Session::flash('message','Escenario actualizado correctamente');
        return redirect()->route('admin.escenarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $escenario=Escenario::findOrFail($id);
        $escenario->delete();

        Session::flash('message','Escenario eliminado correctamente');
        return redirect()->route('admin.escenarios.index');
    }

    public function disable($id)
    {
        $escenario=Escenario::findOrFail($id);
        $escenario->activated=false;
        $escenario->update();
        return back();
    }

    public function enable($id)
    {
        $escenario=Escenario::findOrFail($id);
        $escenario->activated=true;
        $escenario->update();
        return back();
    }
    
}
