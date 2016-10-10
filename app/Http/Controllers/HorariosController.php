<?php

namespace App\Http\Controllers;

use App\Horario;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class HorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horarios=Horario::all();
        return view('campamentos.horarios.index',compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.horarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $horario=new Horario();
        $horario->start_time=$request->get('start_time');
        $horario->end_time=$request->get('end_time');

        $horario->save();
        Session::flash('message','Horario creado correctamente');
        return redirect()->route('admin.horarios.index');
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
        $horario=Horario::findOrFail($id);
        return view('campamentos.horarios.edit',compact('horario'));
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
        $horario=Horario::findOrFail($id);
        $horario->update($request->all());

        Session::flash('message','Horario actualizado correctamente');
        return redirect()->route('admin.horarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $horario=Horario::findOrFail($id);
        $horario->delete();

        Session::flash('message','Horario eliminado correctamente');
        return redirect()->route('admin.horarios.index');
    }

    public function disable($id)
    {
        $horario=Horario::findOrFail($id);
        $horario->activated=false;
        $horario->update();
        return back();
    }

    public function enable($id)
    {
        $horario=Horario::findOrFail($id);
        $horario->activated=true;
        $horario->update();
        return back();
    }
}
