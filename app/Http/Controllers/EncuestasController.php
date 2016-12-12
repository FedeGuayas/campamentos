<?php

namespace App\Http\Controllers;

use App\Encuesta;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

class EncuestasController extends Controller
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
        if ($request){
            $encuestas=Encuesta::all();
        }
        return view('campamentos.encuestas.index', compact('encuestas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.encuestas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $encuesta=new Encuesta;
        $encuesta->encuesta=$request->get('encuesta');
        $encuesta->save();

        Session::flash('message', 'Encuesta creada correctamente');
        return Redirect::to('admin/encuestas') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $encuesta=Encuesta::findOrFail($id);
        return view('campamentos.encuestas.show',compact('encuesta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $encuesta=Encuesta::findOrFail($id);
        return view('campamentos.encuestas.edit',compact('encuesta'));
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
        $encuesta=Encuesta::findOrFail($id);
        $encuesta->update($request->all());

        Session::flash('message','Encuesta actualizada');
        return Redirect::to('admin/encuestas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $encuesta=Encuesta::find($id);
        $encuesta->delete;

        Session::flash('message','Encuesta eliminada');
        return Redirect::to('admin/encuestas');
    }
}
