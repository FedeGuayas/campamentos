<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Modulo;
use App\Pago;
use App\Program;
use Illuminate\Http\Request;

use App\Http\Requests;

class InscripcionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulos_coll = Modulo::where('activated',true);
        $modulos = $modulos_coll->pluck('modulo', 'id');
        $fpagos_coll = Pago::all();
        $fpagos = $fpagos_coll->pluck('forma', 'id');
        return view('campamentos.inscripcions.create',compact('modulos','fpagos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        return ('inscrito');
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function costoUpdate(Request $request)
    {
        if ($request->ajax()) {

            //costo de la matricula para el programa en determinado mes escenario y disciplina
            $escenario_id = $request->get('escenario');
            $disciplina_id = $request->get('disciplina');
            $modulo_id = $request->get('modulo');

            $matricula=Program::
            select('matricula')
                ->where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            if ($request->input('matricula')=='true'){
                $mat=$matricula->matricula;
            }else $mat=0;


            //Al seleccionar el nivel
            $dia_id=$request->get('dia_id');
            $horario_id=$request->get('horario_id');
            $nivel=$request->get('nivel'); //me trae el id del calendario(curso)
            //programa
            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();
            //costo de la mensualidad para el curso
            $mensualidad=Calendar::
                select('mensualidad')
                ->where('program_id',$program->id)
                ->where('dia_id',$dia_id)
                ->where('id',$nivel)
                ->where('horario_id',$horario_id)->first();


            $mes=$mensualidad->mensualidad;

            $precio=$mes+$mat;


            return response( number_format($precio, 2, '.', ' '));
        }
    }
}
