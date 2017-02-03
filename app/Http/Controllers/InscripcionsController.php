<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Descuento;
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
        Carbon::setLocale('es'); //fechas en español
        $this->middleware('auth');
        $this->middleware(['role:planner|administrator'], ['only' => ['update']]);
        $this->middleware(['role:administrator'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inscripciones = Inscripcion::where('estado', 'Pagada')->with('factura', 'calendar', 'user', 'alumno')->get();

        return view('campamentos.inscripcions.index', ['inscripciones' => $inscripciones]);
    }


    /**
     * Muestra las reservaciones
     * @return mixed
     */
    public function reservas()
    {
        $inscripciones = Inscripcion::where('estado', 'Reservada')->with('factura', 'calendar', 'user', 'alumno')->get();
        $reservas = $inscripciones->count();
        
        Session::put('reservas', $reservas);
//        dd(Session::get('reservas'));
        return view('campamentos.inscripcions.reservas', ['inscripciones' => $inscripciones]);
    }


    /**
     * Cancelar reserva
     * @return mixed
     */
    public function reservaCancel($id)
    {
        if (Auth::user()->hasRole(['planner', 'administrator'])) {

            $inscripcion = Inscripcion::where('id', $id)->with('factura', 'calendar', 'user', 'alumno')->first();
            $calendar = $inscripcion->calendar;
            $calendar->decrement('contador');
            $inscripcion->delete();
            $inscripcion->factura->delete();

            Session::flash('message', 'Reserva eliminada');
            return redirect()->back();
        } else return abort(403);
    }

    /**
     * Confirmar reserva
     * @param $id
     * @return mixed
     */
    public function reservaConfirm($id)
    {
        if (Auth::user()->hasRole(['planner', 'administrator'])) {

            $inscripcion = Inscripcion::where('id', $id)->with('factura', 'calendar', 'user', 'alumno')->first();
            $inscripcion->estado = 'Pagada';
            $inscripcion->update();

            Session::flash('message', 'Inscripcion Confirmada');
            return redirect()->back();
        } else return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulos_coll = Modulo::where('activated', true);
        $modulos = $modulos_coll->pluck('modulo', 'id');
        $fpagos_coll = Pago::all();
        $fpagos = $fpagos_coll->pluck('forma', 'id');
        return view('campamentos.inscripcions.create', compact('modulos', 'fpagos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if (Auth::user()->hasRole(['planner', 'administrator', 'signup'])) {


            if (!Session::has('curso')) {//si no hay curso en la session

                try {

                    DB::beginTransaction();
                    $calendar_id = $request->input('calendar_id'); //curso
                    $program_id = $request->input('program_id'); //programa
                    $program = Program::findOrFail($program_id);
                    $matricula = $program->matricula; //matricula del curso
                    $calendar = Calendar::findOrFail($calendar_id);

                    if ($calendar->cupos <= $calendar->contador) { 
                        Session::flash('message_danger', 'No hay disponibilidad para el curso');
                        return redirect()->back();
                    }

                    $mensualidad = $calendar->mensualidad;//mensualidad del curso
                    $valor = $request->input('valor');
                    $pago_id = $request->input('fpago_id');

                    $fpago = Pago::findOrFail($pago_id);
                    $representante = Representante::where('persona_id', $request->input('representante_id'))->first();
                    $factura = new Factura();
                    $factura->pago()->associate($fpago);
                    $factura->representante()->associate($representante);
                    $factura->total = $valor; //costo de la inscripcion

                    if ($request->input('matricula') == 'on') {//pago matricula
                        $sub = $valor - $matricula;
                        $desc = $mensualidad - $sub;
                        if ($desc > 0) {//hay descuento
                            $factura->descuento = $desc;
                        }
                    } else { //no pago matricula
                        $desc = $mensualidad - $valor;
                        if ($desc > 0) {//hay descuento
                            $factura->descuento = $desc;
                        }
                    }

                    $factura->save();

                    if ($request->input('descuento_empleado') == 'true') {
                        $descuentos=new Descuento();
                        $descuentos->factura()->associate($factura);
                        $descuentos->descripcion='DESCUENTO EMPLEADO';
                        $descuentos->valor=$factura->descuento;
                        $descuentos->save();
                    }

                    //inscripcion
                    $user = $request->user();//usuario logueado

                    $inscripcion = new Inscripcion();
                    $inscripcion->calendar()->associate($calendar);
                    $inscripcion->factura()->associate($factura);
                    $inscripcion->user()->associate($user);

                    if ($request->input('adulto') == true) { //si es una inscripcion para adulto
                        $inscripcion->alumno_id = 0; //le voy a asignara al id del alumno 0 en la tabla de inscripcion
                    } else {
                        $inscripcion->alumno_id = $request->input('alumno_id'); //sino el id del input del form
                    }

                    if ($request->input('matricula') == true) { //si va a pagar matricula
                        $inscripcion->matricula = $matricula; //le asigno el valor 
                    }

                    if ($request->input('reservar') == 'on') { //si va a reservar
                        $inscripcion->estado = 'Reservada'; //el estado de la reserva sera 'Reservada'
                    }
                    $inscripcion->mensualidad = $mensualidad;

                    $inscripcion->save();

                    DB::commit();

                    //aumentar contadores
                    Event::fire(new NuevaInscripcion($calendar));//al guardar correctamenta la inscripcion llamao al evento de aumentar contador

                    Session::flash('message', 'Inscripción satisfactoria');


                } catch (\Exception $e) { //en caso de error viro al estado anterior
                    DB::rollback();
                    Session::flash('message_danger', 'Error' . $e->getMessage());
                    return redirect()->route('admin.inscripcions.index');
                }

                return redirect()->route('admin.inscripcions.index');
            }


            //Existen cursos Multiples almacenados en la Session, asi k los almaceno todos

            //inscripcion familiar no puede tener menos de dos inscritos
            if ($request->input('familiar') == true && Session::get('curso')->totalCursos < 2) {
                Session::flash('message_danger', 'No se permiten menos de 2 inscripciones para el grupo Familiar');
                return redirect()->back();
            }

            //inscripcion multiples no puede tener menos de 3 inscritos y no puede ser en invierno
            if (($request->input('multiple') == true && Session::get('curso')->totalCursos < 3) || $request->input('descuento_estacion') == 'INVIERNO') {
                Session::flash('message_danger', 'No se permiten menos de 3 inscripciones para el grupo Multiple o esta fuera de temporada');
                return redirect()->back();
            }

            //si es inscripcion variada tiene que estar marcado o familira o multiple
            if (Session::get('curso')->totalCursos > 0 && ($request->input('familiar') == false && $request->input('multiple') == false)) {
                Session::flash('message_danger', 'Debe seleccionar Familiar o Multiple, según corresponda');
                return redirect()->back();
            }


            $oldCurso = Session::get('curso');//obtengo la variable de la session
            $cart = new Multiples($oldCurso); //creo una instancia de la clase 

            $cursos = $cart->cursos;  //arreglo con los cursos agrupados por curso Items

            $precioTotal = $cart->totalPrecio;//precio unitario de la compra de los cursos sin matricula
            $tipo_descuento = $cart->tipo_desc; //tipo de desceunto aplicado
            $desc_emp = $cart->desc_empleado;//true o false

            if ($tipo_descuento == 'familiar' || $tipo_descuento == 'multiple') {//si el descunto es familiar o multiple
                $desc1 = 0.1;
                $descuento = $precioTotal * $desc1; //descuento aplicado a la mensualidad total
            }

            if ($desc_emp == 'true') { //en caso de empleado
                $desc2 = 0.5;
                $descuento = $precioTotal * $desc2; //descuento aplicado a la mensualidad total
            }

            $matricula=0;
            foreach ($cursos as $curso){
                $matricula+=$curso['matricula']; //costo de la matricula
            }
            
            $total = ($precioTotal+ $matricula) - $descuento; //total con descuentos aplicados

            try {
                DB::beginTransaction();

                $user = Auth::user(); //usuario autenticado
                $pago_id = $request->input('fpago_id');
                $fpago = Pago::findOrFail($pago_id); //forma de pago
                
                $representante = $cart->representante;
               
                $factura = new Factura();
                $factura->pago()->associate($fpago);
                $factura->representante()->associate($representante);
                $factura->total = $total;
                $factura->descuento = $descuento;

                $factura->save(); //se guarda una sola factura 

                $descuentos=new Descuento();
                $descuentos->factura()->associate($factura);
                $descuentos->valor=$descuento;
                
                if ($tipo_descuento == 'familiar') {
                    $descuentos->descripcion='DESCUENTO FAMILIAR';
                    $descuentos->save();
                }
                if ($tipo_descuento == 'multiple') {
                    $descuentos->descripcion='DESCUENTO MULTIPLE';
                    $descuentos->save();
                }
                if ($desc_emp == 'true') {
                    $descuentos->descripcion='DESCUENTO EMPLEADO';
                    $descuentos->save();
                }

                
                foreach ($cursos as $curso) {//recorro los cursos dentro de la coleccion (carrito)
                    $calendar = $curso['curso']; //1 curso dentro del item (storedCurso) de cursos 
                    if ($calendar->cupos < $calendar->contador + $curso['qty']) {//cupos no puede ser menor k la suma
                        Session::flash('message_danger', 'No hay disponibilidad para el curso');
                        return redirect()->back();
                    }
                                        
                    foreach ($curso['alumno'] as $alumno) {//por cada alumno en cada curso hago una incripcion
                        $inscripcion = new Inscripcion();
                        $inscripcion->mensualidad=$calendar->mensualidad;
                        $inscripcion->matricula=$curso['matricula']/$curso['qty'];
                        $inscripcion->calendar()->associate($calendar);
                        $inscripcion->factura()->associate($factura);
                        $inscripcion->user()->associate($user);
                        
                        if ($request->input('reservar') == 'on') {
                            $inscripcion->estado = 'Reservada';
                        }

                        if ($alumno->id==$representante->id) {//adulto por tanto el rep =alumno
                            $inscripcion->alumno_id = 0;
                        } else {
                            $inscripcion->alumno_id = $alumno->id;
                        }

                        $inscripcion->save();
                        Event::fire(new NuevaInscripcion($calendar));
                    }
                }
                DB::commit();

            } catch (\Exception $e) {
                Session::flash('message_danger', $e->getMessage());
                return redirect()->route('admin.inscripcions.create');
            }

            Session::forget('curso');//limpiando la session, vaciando el carrito
            Session::flash('message', 'Inscripcion satisfactoria');
            return redirect()->route('admin.inscripcions.index');

        } else return abort(403);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ('Ahh ahh ahh no implementado Sorry');
    }

    /**
     * Muestra el formulario para editar la inscripcion seleccionada.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inscripcion = Inscripcion::where('id', $id)->with('factura', 'calendar', 'user', 'alumno')->first();

        if ($inscripcion->alumno_id == 0) { //si es inscripcion de adulto
            $alumno_id = $inscripcion->factura->representante_id;
            $alumno = $inscripcion->factura->representante->persona->getNombreAttribute();
            $representante = $inscripcion->factura->representante->persona->getNombreAttribute();
            $representante_id = $inscripcion->factura->representante_id;
        } else { //si es inscripcion de menor
            $alumno_id = $inscripcion->alumno_id;
            $alumno = $inscripcion->alumno->persona->getNombreAttribute();
            $representante = $inscripcion->factura->representante->persona->getNombreAttribute();
            $representante_id = $inscripcion->factura->representante_id;
        }

        $fact_id = $inscripcion->factura_id;
        $count_fact = Inscripcion::where('factura_id', '=', $fact_id)->count();

        if ($count_fact > 1) { //si es una inscripcion multiple
            $tipo_inscripcion = 'multiple';
        } else { //inscripcion sencilla
            $tipo_inscripcion = 'sencilla';
        }

        $costo_anterior = $inscripcion->factura->total; //total de la factura con descuento si tiene
        $descuento = $inscripcion->factura->descuento; //descuento de la factura
        $costo_inscripcion = $inscripcion->matricula + $inscripcion->mensualidad; //matricula+mensualidad
        $curso_guardado=$inscripcion->calendar_id;

        
        $modulos_coll = Modulo::where('activated', true);
        $modulos = $modulos_coll->pluck('modulo', 'id');
        $fpagos_coll = Pago::all();
        $fpagos = $fpagos_coll->pluck('forma', 'id');
        
        return view('campamentos.inscripcions.edit', compact('modulos', 'fpagos', 'inscripcion','tipo_inscripcion','curso_guardado',
            'alumno','alumno_id','representante','representante_id','costo_anterior','descuento','costo_inscripcion'));

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //eliminar, no implementar

        if(Auth::user()->hasRole(['planner','administrator','signup'])) {

            try {

                DB::beginTransaction();

                $inscripcion=Inscripcion::where('id',$id)->with('factura','calendar','user','alumno')->first();

                if  ($request->input('tipo_inscripcion')=='sencilla'){ //inscripcion individual
                }else { //multiple
                }

                $calendar_id = $request->input('calendar_id'); //curso
                $calendar = Calendar::findOrFail($calendar_id);

                $program_id = $request->input('program_id'); //programa
                $program = Program::findOrFail($program_id);

                $matricula = $program->matricula; //matricula del curso

                //si se cambia de curso y no hay disponibilidad
                if ( ($request->input('curso_guardado')<>$calendar_id) && ($calendar->cupos <= $calendar->contador) ) {
                    Session::flash('message_danger', 'No hay disponibilidad para el curso');
                    return redirect()->back();
                }


                $mensualidad = $calendar->mensualidad;//mensualidad del curso
                $valor_actual = $request->input('valor');//costo de la nueva inscripcion editada
                $valor_anterior=$request->input('costo_anterior');//valor neto de la factura antes de ser editada la insc

                $descuento_factura=$request->input('descuento_factura'); //descuento de la factura
                $costo_inscripcion=$request->input('costo_inscripcion'); //matricula+mensualidad

                $pago_id = $request->input('fpago_id');

                $fpago = Pago::findOrFail($pago_id);
//                $representante = Representante::where('persona_id', $request->input('representante_id'))->first();
                $factura = Factura::where('id',$inscripcion->factura_id);
                $factura->pago()->associate($fpago);
//                $factura->representante()->associate($representante);
                $factura->total = $valor_actual; //costo de la inscripcion editada

                if ($request->input('matricula') == 'on') {//pago matricula
                    $sub = $valor_actual - $matricula;
                    $desc = $mensualidad - $sub;
                    if ($desc > 0) {//hay descuento
                        $factura->descuento = $desc;
                    }
                } else { //no pago matricula
                    $desc = $mensualidad - $valor_actual;
                    if ($desc > 0) {//hay descuento
                        $factura->descuento = $desc;
                    }
                }

                $factura->update();

                if ($request->input('descuento_empleado') == 'true') {
                    $descuentos=Descuento::where('factura_id',$inscripcion->factura_id);
                    $descuentos->factura()->associate($factura);
                    $descuentos->descripcion='DESCUENTO EMPLEADO';
                    $descuentos->valor=$factura->descuento;
                    $descuentos->update();
                }

                //inscripcion

                $inscripcion->calendar()->associate($calendar);
                $inscripcion->factura()->associate($factura);
                $inscripcion->user_edit=$request->user();//usuario logueado

               // if ($request->input('adulto') == true) { //si es una inscripcion para adulto
                 //   $inscripcion->alumno_id = 0; //le voy a asignara al id del alumno 0 en la tabla de inscripcion
                //} else {
                  //  $inscripcion->alumno_id = $request->input('alumno_id'); //sino el id del input del form
                //}

                if ($request->input('matricula') == true) { //si va a pagar matricula
                    $inscripcion->matricula = $matricula; //le asigno el valor
                }

                //if ($request->input('reservar') == 'on') { //si va a reservar
                  //  $inscripcion->estado = 'Reservada'; //el estado de la reserva sera 'Reservada'
                //}
                $inscripcion->mensualidad = $mensualidad;

                $inscripcion->update();

                DB::commit();

                if  ($request->input('curso_guardado')<>$calendar_id){
                    //aumentar contadores
                    Event::fire(new NuevaInscripcion($calendar));//al guardar correctamenta la inscripcion llamao al evento de aumentar contador
                }

              //  $calendar->decrement('contador');

                Session::flash('message', 'Actualización satisfactoria');

            } catch (\Exception $e) { //en caso de error viro al estado anterior
                DB::rollback();
                Session::flash('message_danger', 'Error' . $e->getMessage());
                return redirect()->route('admin.inscripcions.index');
            }

            return redirect()->route('admin.inscripcions.index');
        }else
            return abort(403);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->hasRole(['planner','administrator','signup'])) {

            $inscripcion=Inscripcion::where('id',$id)->with('factura','calendar','user','alumno')->first();

            $calendar_id = $inscripcion->calendar_id;
            $calendar = Calendar::findOrFail($calendar_id);

            $fact_id = $inscripcion->factura_id;
            $count_fact = Inscripcion::where('factura_id', '=', $fact_id)->count();

            if ($count_fact > 1) { //si es una inscripcion multiple

                for ($i=0;$i<$count_fact;$i++){ //eliminar cada inscripcion asociada
                    $inscripcion_m = Inscripcion::where('factura_id',$fact_id)->first();
                    $calendar = Calendar::findOrFail($inscripcion_m->calendar_id);
                    if ( ($calendar->contador)>0){
                        $calendar->decrement('contador');
                    }else{
                        Session::flash('message_danger', 'No hay inscripciones para este curso ');
                        return redirect()->back();
                    }

                    $inscripcion_m->delete();
                }
                $descuento=Descuento::where('factura_id',$inscripcion->factura_id);
                $descuento->delete();
                $factura = Factura::where('id',$inscripcion->factura_id);
                $factura->delete();

                $tipo_inscripcion = 'multiple';
                Session::flash('message_danger', 'Inscripcion multiple, se eliminaron todas las inscripciones asociadas');
                return redirect()->back();

            } else { //inscripcion sencilla

                if ( ($calendar->contador)>0){
                    $calendar->decrement('contador');
                }else{
                    Session::flash('message_danger', 'No hay inscripciones para este curso ');
                    return redirect()->back();
                }
                $descuento=Descuento::where('factura_id',$inscripcion->factura_id);
                $descuento->delete();
                $factura = Factura::where('id',$inscripcion->factura_id);
                $factura->delete();
                $inscripcion->delete();
                Session::flash('message_danger', 'Inscripción eliminada');
                return redirect()->route('admin.inscripcions.index');
            }


        }else
            return abort(403);
    }


    /**
     *  Actualizacion del costo del curso
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function costoUpdate(Request $request)
    {
        if ($request->ajax()) {

            //costo de la matricula para el programa en determinado mes escenario y disciplina
            $escenario_id = $request->get('escenario');
            $disciplina_id = $request->get('disciplina');
            $modulo_id = $request->get('modulo');
            $matricula = Program::
                select('matricula')
                ->where('escenario_id', $escenario_id)
                ->where('disciplina_id', $disciplina_id)
                ->where('modulo_id', $modulo_id)->first();

            //Al seleccionar el nivel
            $dia_id = $request->get('dia_id');
            $horario_id = $request->get('horario_id');
            $nivel = $request->get('nivel'); //me trae el id del calendario(curso)
            
            //programa
            $program = Program::where('escenario_id', $escenario_id)
                ->where('disciplina_id', $disciplina_id)
                ->where('modulo_id', $modulo_id)->first();
            
            //costo de la mensualidad para el curso
            $mensualidad = Calendar::
            select('mensualidad')
                ->where('program_id', $program->id)
                ->where('dia_id', $dia_id)
                ->where('id', $nivel)
                ->where('horario_id', $horario_id)->first();

            $mes = $mensualidad->mensualidad;
            
            if ($request->input('descuento_empleado') == 'true') {
                $desc = 0.5; //50%
                $descuento =$mes * $desc;
            } else if ( $request->input('descuento_familiar') == 'true' ||
                ( ($request->input('descuento_multiple') == 'true') && ($request->input('descuento_estacion') == 'VERANO') ) ){
                $desc = 0.1; //10%
                $descuento =$mes * $desc;
            }else  $descuento=0;

            if ($request->input('matricula') == 'true') {
                $mat = $matricula->matricula;
            } else $mat = 0;

            $precio = $mat + $mes - $descuento;

            return response(number_format($precio, 2, '.', ' '));
        }
    }
}
