<?php

namespace App\Http\Controllers;

use App\Dia;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class DiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dias=Dia::all()->sortBy('dia');
        return view('campamentos.dias.index',compact('dias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.dias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dia=new Dia();
        $dia->dia=$request->get('dia');
        
        $dia->save();
        Session::flash('message','Dias creados correctamente');
        return redirect()->route('admin.dias.index');
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
        $dia=Dia::findOrFail($id);
        return view('campamentos.dias.edit',compact('dia'));
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
        $dia=Dia::findOrFail($id);
        $dia->update($request->all());

        Session::flash('message','Dias actualizados correctamente');
        return redirect()->route('admin.dias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dia=Dia::findOrFail($id);
        $dia->delete();

        return redirect()->route('admin.dias.index');
    }

    public function disable($id)
    {
        $dia=Dia::findOrFail($id);
        $dia->activated=false;
        $dia->update();
        return back();
    }

    public function enable($id)
    {
        $dia=Dia::findOrFail($id);
        $dia->activated=true;
        $dia->update();
        return back();
    }
}
