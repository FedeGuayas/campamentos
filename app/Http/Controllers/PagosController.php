<?php

namespace App\Http\Controllers;

use App\Pago;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fpagos=Pago::all();
        return view('campamentos.fpagos.index',compact('fpagos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.fpagos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fpago=new Pago;
        $fpago->forma=strtoupper($request->get('forma'));
        $fpago->descripcion=strtoupper($request->get('descripcion'));
        $fpago->save();
        Session::flash('message','Forma de pago creada');
        return redirect()->route('admin.fpagos.index');
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fpago=Pago::findOrFail($id);
        return view('campamentos.fpagos.edit',compact('fpago'));
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
        $fpago=Pago::findOrFail($id);
        $fpago->forma=strtoupper($request->get('forma'));
        $fpago->descripcion=strtoupper($request->get('descripcion'));
        $fpago->update();
        Session::flash('message','Forma de pago actualizada');
        return redirect()->route('admin.fpagos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fpago=Pago::findOrFail($id);
        $fpago->delete();
        Session::flash('message','Forma de pago eliminada');
        return redirect()->route('admin.fpagos.index');
    }
}
