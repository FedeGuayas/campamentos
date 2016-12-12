<?php

namespace App\Http\Controllers;

use App\Disciplina;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class DisciplinasController extends Controller
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
        $disciplinas=Disciplina::all()->sortBy('disciplina');
        return view('campamentos.disciplinas.index',compact('disciplinas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.disciplinas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $disciplina=new Disciplina;
        $disciplina->disciplina=$request->get('disciplina');
        $disciplina->activated=true;

        $disciplina->save();
        Session::flash('message','Disciplina creada correctamente');
        return redirect()->route('admin.disciplinas.index');
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
        $disciplina=Disciplina::findOrFail($id);
        return view('campamentos.disciplinas.edit',compact('disciplina'));
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
        $disciplina=Disciplina::findOrFail($id);
        $disciplina->update($request->all());

        Session::flash('message','Disciplina actualizada correctamente');
        return redirect()->route('admin.disciplinas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $disciplina=Disciplina::findOrFail($id);
        $disciplina->delete();

        Session::flash('message','Disciplina eliminada correctamente');
        return redirect()->route('admin.disciplinas.index');
    }

    public function disable($id)
    {
        $disciplina=Disciplina::findOrFail($id);
        $disciplina->activated=false;
        $disciplina->update();
        return back();
    }

    public function enable($id)
    {
        $disciplina=Disciplina::findOrFail($id);
        $disciplina->activated=true;
        $disciplina->update();
        return back();
    }
    
}
