<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Events\NuevaInscripcion;
use App\Factura;
use App\Inscripcion;
use App\Modulo;
use App\Pago;
use App\Program;
use App\Representante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\InscripcionStoreRequest;
use DB;
use Session;
use Event;

use App\Http\Requests;

class InscripcionsController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inscripciones=Inscripcion::where('estado','Pagada')->with('factura','calendar','user','alumno')->get();

        return view('campamentos.inscripcions.index',['inscripciones'=>$inscripciones]);
    }


    /**
     * Muestra las reservaciones
     * @return mixed
     */
    public function reservas()
    {
        $inscripciones=Inscripcion::where('estado','Reservada')->with('factura','calendar','user','alumno')->get();
        $reservas=$inscripciones->count();

        Session::put('reservas',$reservas);
//        dd(Session::get('reservas'));
        return view('campamentos.inscripcions.reservas',['inscripciones'=>$inscripciones]);
    }


    /**
     * Cancelar reserva
     * @return mixed
     */
    public function reservaCancel($id)
    {

        $inscripcion=Inscripcion::where('id',$id)->with('factura','calendar','user','alumno')->first();
        $calendar=$inscripcion->calendar;
        $calendar->decrement('contador');
        $inscripcion->delete();
        $inscripcion->factura->delete();

        Session::flash('message','Reserva eliminada');
        return redirect()->back();
    }

    /**
     * Confirmar reserva
     * @param $id
     * @return mixed
     */
    public function reservaConfirm($id)
    {

        $inscripcion=Inscripcion::where('id',$id)->with('factura','calendar','user','alumno')->first();
        $inscripcion->estado='Pagada';
        $inscripcion->update();

        Session::flash('message','Inscripcion Confirmada');
        return redirect()->back();
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

        try {
            DB::beginTransaction();
            $calendar_id=$request->input('calendar_id');
            $program_id=$request->input('program_id');
            $program=Program::findOrFail($program_id);
            $matricula=$program->matricula;
            $calendar=Calendar::findOrFail($calendar_id);
            $mensualidad=$calendar->mensualidad;
            $valor=$request->input('valor');
            $pago_id=$request->input('fpago_id');

            $fpago=Pago::findOrFail($pago_id);
            $representante=Representante::where('persona_id',$request->input('representante_id'))->first();
            $factura=new Factura();
            $factura->pago()->associate($fpago);
            $factura->representante()->associate($representante);
            $factura->total=$valor;

            if ($request->input('matricula')=='on'){
                $sub=$valor-$matricula;
                $desc=$mensualidad-$sub;
                if ($desc>0){
                    $factura->descuento=$desc;
                }
            } else{
                $desc=$mensualidad-$valor;
                if ($desc>0){
                    $factura->descuento=$desc;
                }
            }

            $factura->save();

        //inscripcion
        $user=$request->user();

        $inscripcion=new Inscripcion();
        $inscripcion->calendar()->associate($calendar);
        $inscripcion->factura()->associate($factura);
        $inscripcion->user()->associate($user);

        if ($request->input('adulto')==true){
            $inscripcion->alumno_id=0;
        }else {
            $inscripcion->alumno_id=$request->input('alumno_id');
        }
            
        if ($request->input('matricula')==true){
            $inscripcion->matricula=$matricula;
        }

        if ($request->input('reservar')=='on'){
            $inscripcion->estado='Reservada';
        }
        $inscripcion->mensualidad=$mensualidad;

        $inscripcion->save();

            DB::commit();

            //aumentar contadores
            Event::fire(new NuevaInscripcion($calendar));

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('message_danger', 'Error' . $e->getMessage());
            return redirect()->route('admin.inscripcions.index');
        }
        Session::flash('message','Inscripción satisfactoria');
        return redirect()->route('admin.inscripcions.index');
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

            if ($request->input('descuento_familiar')=='true'){
                $desc_familiar=0.1; //10%
            }else $desc_familiar=0;

            if ($request->input('descuento_empleado')=='true'){
                $desc_empleado=0.5; //50%
            }else $desc_empleado=0;

            if ($request->input('descuento_estacion')=='VERANO'){
                //condiciones para verano 10% ins de mas de un representado inscrito o 10% un inscrito en una disciplina mas de 3 meses
                if ($request->input('descuento_multiple')=='true'){
                    $desc_multiple=0.1; //10%
                }else $desc_multiple=0;

            }elseif ($request->input('descuento_estacion')=='INVIERNO'){
                //condiciones para invierno ... Dewcuento del 10% para inscripciones en mas de 3 meses en el mismo curso
                $desc_multiple=0;
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

            $descuentos=($mes*$desc_empleado)+($mes*$desc_multiple)+($mes*$desc_familiar);

            $precio=$mat+($mes-($descuentos));

            return response( number_format($precio, 2, '.', ' '));
        }
    }
}
