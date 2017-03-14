<?php

namespace App\Http\Controllers;

use App\Descuento;
use App\Factura;
use App\Inscripcion;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Yajra\Datatables\Datatables;

class FacturasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:administrator'],['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $comprobantes=Factura::with('representante','inscripcions')->get();
        
//        return view('campamentos.facturas.index', compact('comprobantes'));
        return view('campamentos.facturas.index');
    }

    /**
     * Obtener el listado de todos los alumnos para datatables con ajax
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request)
    {
        if ($request->ajax()){
            
            $comprobantes = Factura::with('representante','inscripcions')->selectRaw('distinct facturas.*');


            $action_buttons =
                '@if ( Auth::user()->hasRole([\'administrator\']))
                <a href="{{ route(\'admin.facturas.delete\',[$id] ) }}" onclick="
                return confirm(\'Seguro que desea borrar la factura?\')">
                   {!! Form::button(\'<i class="tiny fa fa-trash-o" ></i>\',[\'class\'=>\'label waves-effect waves-light red darken-1\']) !!}
                 @endif
                 ';
            //{!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-[$id]"]) !!}
            return Datatables::of($comprobantes)

                ->addColumn('inscripcion', function (Factura $factura) {
                    return $factura->inscripcions->map(function($insc) {
                        return ($insc->id);
                    })->implode('<br>');
                })
                
                ->addColumn('actions', $action_buttons)

                ->make(true);
        }

        return view('campamentos.alumnos.index');
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $factura=Factura::findOrFail($id);
        $inscripcion=Inscripcion::where('factura_id',$id)->delete();
        $descuento=Descuento::where('factura_id',$id)->delete();
        
        $factura->delete;
        Session::flash('message','Comprobante eliminado');
        return redirect()->route('admin.facturas.index');
    }
}
