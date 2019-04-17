<?php

namespace App\Http\Controllers;

use App\TipoDescuento;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class TipoDescuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $descuentos=TipoDescuento::all();
        return view('campamentos.descuentos.index',compact('descuentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.descuentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombre = $request->input('nombre');
        $porciento = (integer)$request->input('porciento');
        $descripcion= $request->input('descripcion');

        if (strlen($descripcion)=== 0) {
            return redirect()->back()->with('message_danger','Debe escribir una descripción');
        }

        $descuento= new TipoDescuento();
        $descuento->nombre = $nombre;
        $descuento->porciento = $porciento;
        $descuento->descripcion = $descripcion;
        $descuento->multiplicador = $porciento;
        $descuento->save();

        Session::flash('message','Descuento creado');
        return redirect()->route('admin.tipo_descuentos.index');
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
        $descuento=TipoDescuento::findOrFail($id);
        return view('campamentos.descuentos.edit',compact('descuento'));
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
        $descuento=TipoDescuento::findOrFail($id);

        $nombre = $request->input('nombre');
        $porciento = (integer)$request->input('porciento');
        $descripcion= $request->input('descripcion');

        if (strlen($descripcion)=== 0) {
            return redirect()->back()->with('message_danger','Debe escribir una descripción');
        }

        $descuento->nombre = $nombre;
        $descuento->porciento = $porciento;
        $descuento->descripcion = $descripcion;
        $descuento->multiplicador = $porciento;
        $descuento->update();

        Session::flash('message','Descuento actualizado');
        return redirect()->route('admin.tipo_descuentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $descuento=TipoDescuento::findOrFail($id);
        $descuento->delete();
        Session::flash('message','Descuento eliminado');
        return redirect()->route('admin.tipo_descuentos.index');
    }
}
