<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Events\NuevaInscripcion;
use App\Factura;
use App\Inscripcion;
use App\Modulo;
use App\Multiples;
use App\Pago;
use App\Program;
use App\Representante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\InscripcionStoreRequest;
use DB;
use Illuminate\Support\Facades\Auth;
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
    public function store(Request $request)
    {
        
        if (!Session::has('curso')){//si no hay curso en la session

            try {

                DB::beginTransaction();
                $calendar_id=$request->input('calendar_id');
                $program_id=$request->input('program_id');
                $program=Program::findOrFail($program_id);
                $matricula=$program->matricula;
                $calendar=Calendar::findOrFail($calendar_id);

                if ($calendar->cupos<=$calendar->contador){
                    Session::flash('message_danger','No hay disponibilidad para el curso');
                    return redirect()->back();
                }

                $mensualidad=$calendar->mensualidad;
                $valor=$request->input('valor');
                $pago_id=$request->input('fpago_id');

                $fpago=Pago::findOrFail($pago_id);
                $representante=Representante::where('persona_id',$request->input('representante_id'))->first();
                $factura=new Factura();
                $factura->pago()->associate($fpago);
                $factura->representante()->associate($representante);
                $factura->total=$valor;

                if ($request->input('matricula')=='on'){//aplico matricula
                    $sub=$valor-$matricula;
                    $desc=$mensualidad-$sub;
                    if ($desc>0){//hay descuento
                        $factura->descuento=$desc;
                    }
                } else{
                    $desc=$mensualidad-$valor;
                    if ($desc>0){//hay descuento
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

                Session::flash('message','Inscripción satisfactoria');
               

            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('message_danger', 'Error' . $e->getMessage());
                return redirect()->route('admin.inscripcions.index');
            }

            return redirect()->route('admin.inscripcions.index');
        }


        //  guardar los cursos multiples almacenados en la session

        //inscripcion familiar no puede tener menos de dos inscritos
        if ( $request->input('familiar')==true && Session::get('curso')->totalCursos<2 ){
            Session::flash('message_danger','No se permiten menos de 2 inscripciones para el grupo Familiar');
            return redirect()->back();
        }

        //inscripcion multiples no puede tener menos de 3 inscritos y no puede ser en invierno
        if ( ($request->input('multiple')==true && Session::get('curso')->totalCursos<3) ||  $request->input('descuento_estacion')=='INVIERNO'){
            Session::flash('message_danger','No se permiten menos de 3 inscripciones para el grupo Multiple o esta fuera de temporada');
            return redirect()->back();
        }

        //si es inscripcion variada tiene que estar marcado o familira o multiple
        if ( Session::get('curso')->totalCursos>0 && ($request->input('familiar')==false && $request->input('multiple')==false)){
            Session::flash('message_danger','Debe seleccionar Familiar o Multiple, según corresponda');
            return redirect()->back();
        }


        $oldCurso=Session::get('curso');//obtengo la variable de la session
        $cart=new Multiples($oldCurso); //creo una instancia de la clase 

        $cursos=$cart->cursos;  //arreglo con los cursos agrupados por curso Items

        $precioTotal=$cart->totalPrecio;
        $tipo_descuento=$cart->tipo_desc;
        $desc_emp=$cart->desc_empleado;

        if ($tipo_descuento=='familiar' || $tipo_descuento=='multiple'){
            $desc1=0.1;
        }else  $desc1=0;

        if ($desc_emp=='true'){
            $desc2=0.5;
        }else  $desc2=0;

        $descuento=$precioTotal*$desc1 + $precioTotal*$desc2;

        $total=$precioTotal-$descuento;

        try {
            DB::beginTransaction();

            $user= Auth::user();
        $pago_id=$request->input('fpago_id');
        $fpago=Pago::findOrFail($pago_id);
        $representante=$cart->representante;
        $factura=new Factura();
        $factura->pago()->associate($fpago);
        $factura->representante()->associate($representante);
        $factura->total=$total;
        $factura->descuento=$descuento;

        $factura->save();


        foreach ($cursos as $curso){//recorro los cursos
            $calendar=$curso['curso'];
            if ($calendar->cupos < $calendar->contador+$curso['qty']){//cupos no puede ser menor k la suma
                Session::flash('message_danger','No hay disponibilidad para el curso');
                return redirect()->back();
            }
            foreach ($curso['alumno'] as $alumno){//por cada alumno en cada curso hago una incripcion
                $inscripcion=new Inscripcion();

                $inscripcion->calendar()->associate($calendar);
                $inscripcion->factura()->associate($factura);
                $inscripcion->user()->associate($user);


                if ($request->input('reservar')=='on'){
                    $inscripcion->estado='Reservada';
                }

                if ($request->input('adulto')==true){
                    $inscripcion->alumno_id=0;
                }else {
                    $inscripcion->alumno_id=$alumno->id;
                }

                $inscripcion->save();
                Event::fire(new NuevaInscripcion($calendar));
                }
        }
            DB::commit();

        }catch(\Exception $e){
            Session::flash('message_danger',$e->getMessage());
            return redirect()->route('admin.inscripcions.create');
        }

        Session::forget('curso');//limpiando la session, vaciando el carrito
        Session::flash('message','Inscripcion satisfactoria');
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
