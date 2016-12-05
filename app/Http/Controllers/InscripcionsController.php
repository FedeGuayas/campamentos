<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Factura;
use App\Inscripcion;
use App\Modulo;
use App\Pago;
use App\Program;
use App\Representante;
use Illuminate\Http\Request;
use App\Http\Requests\InscripcionStoreRequest;
use DB;

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
        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')->get();

        return view('campamentos.inscripcions.index',['inscripciones'=>$inscripciones]);
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
    public function store(InscripcionStoreRequest $request)
    {

        //factura
        try {
            DB::beginTransaction();

        $pago_id=$request->input('fpago_id');
        $fpago=Pago::findOrFail($pago_id);
        $representante=Representante::where('persona_id',$request->input('representante_id'))->first();
        $factura=new Factura();
        $factura->pago()->associate($fpago);
        $factura->representante()->associate($representante);
        $factura->total=$request->input('valor');
//        if (!$request->input('descuentos')==''){
//            $factura->descuento=$request->input('descuento');
//        }
        $factura->total=$request->input('valor');
        $factura->save();

        //inscripcion
        $user=$request->user();
        $calendar_id=$request->input('calendar_id');
        $program_id=$request->input('program_id');
        $program=Program::findOrFail($program_id);
        $calendar=Calendar::findOrFail($calendar_id);
        $inscripcion=new Inscripcion();
        $inscripcion->calendar()->associate($calendar);
        $inscripcion->factura()->associate($factura);
        $inscripcion->user()->associate($user);
        if ($request->input('adulto')==true){
            $inscripcion->alumno_id=$request->input('representante_id');
        }else {
            $inscripcion->alumno_id=$request->input('alumno_id');
        }
        if ($request->input('matricula')==true){
            $inscripcion->matricula=$program->matricula;
        }
        $inscripcion->mensualidad=$calendar->mensualidad;

        $inscripcion->save();

            DB::commit();


        } catch (\Exception $e) {
            DB::rollback();
        }


        return back()->with('message','Inscripción satisfactoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ('Vista generakl de la inscripcion');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return ('formulario editar inscripcion');
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
        return ('inscripcion editada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ('inscripcion eliminada');
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

            if ($request->input('descuento_empleado')=='true'){
                $desc_empleado=0.5; //50%
            }else $desc_empleado=0;

            if ($request->input('descuento_estacion')=='VERANO'){
                //condiciones para verano 10% ins de mas de un representado inscrito o 10% un inscrito en una disciplina mas de 3 meses
                
            }elseif ($request->input('descuento_estacion')=='INVIERNO'){
                //condiciones para invierno ... Dewcuento del 10% para inscripciones en mas de 3 meses en el mismo curso
            }


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

            $precio=$mat+($mes-($mes*$desc_empleado));

            return response( number_format($precio, 2, '.', ' '));
        }
    }
}
