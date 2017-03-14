<?php

namespace App\Http\Controllers;

use App\Alumno;
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
use Yajra\Datatables\Datatables;


class InscripcionsController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es'); //fechas en español
        $this->middleware('auth');
        $this->middleware(['role:planner|administrator'], ['only' => ['update']]);
        $this->middleware(['role:administrator|supervisor|planner'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $inscripciones = Inscripcion::where('estado', 'Pagada')->with('factura', 'calendar', 'user', 'alumno')->get();

//        return view('campamentos.inscripcions.index', ['inscripciones' => $inscripciones]);
        return view('campamentos.inscripcions.index');
    }


    /**
     * Obtener el listado de todas las inscripciones para datatables con ajax
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request)
    {

        if ($request->ajax()){

            $inscripciones = Inscripcion::
            with('factura', 'calendar', 'user', 'alumno')
                ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
                ->join('programs', 'programs.id', '=', 'calendars.program_id')
                ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
                ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
                ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
                ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
                ->join('profesors', 'profesors.id', '=', 'calendars.profesor_id')
                ->join('dias', 'dias.id', '=', 'calendars.dia_id')
                ->join('facturas','facturas.id','=','inscripcions.factura_id')
                ->join('representantes','representantes.id','=','facturas.representante_id')
                ->join('personas','personas.id','=','representantes.persona_id')
                //    ->join('alumnos','alumnos.id','=','inscripcions.alumno_id')
                //  ->join('personas','personas.id','=','alumnos.persona_id')
                ->select('inscripcions.id', 'inscripcions.alumno_id', 'inscripcions.factura_id', 'inscripcions.calendar_id', 'user_id', 'inscripcions.created_at', 'programs.disciplina_id', 'programs.escenario_id')
                ->where('estado', 'Pagada');
            

            $action_buttons = '
                                <a href="{{  route(\'admin.reports.pdf\',[$id] ) }}">
                                {!! Form::button(\'<i class="tiny fa fa-file-pdf-o"></i>\',[\'class\'=>\'label waves-effect waves-light teal darken-1  orange accent-4\']) !!}
                               </a>
                               
                                @if ( Entrust::hasRole([\'planner\',\'administrator\']) )
                                <a href="{{ route(\'admin.inscripcions.edit\', [$id] ) }}">
                                {!! Form::button(\'<i class="tiny fa fa-pencil-square-o" ></i>\',[\'class\'=>\'label waves-effect waves-light teal darken-1\']) !!}
                                 </a>
                                 @endif
                                 
                                   <a href="{{ route(\'admin.inscripcions.re-inscribir\', [$id] ) }}">
                                {!! Form::button(\'<i class="tiny fa fa-repeat" ></i>\',[\'class\'=>\'label waves-effect waves-light blue darken-1\']) !!}
                                 </a>
                               
                            @if (Entrust::can(\'delete_inscripcion\'))
                                @if(Auth::user()->escenario_id==$escenario_id ||  Entrust::hasRole(\'administrator\'))
                                    {!! Form::button(\'<i class="tiny fa fa-trash-o" ></i>\',[\'class\'=>\'label waves-effect waves-light red darken-1\',\'value\'=>$id,\'onclick\'=>\'eliminar(this)\']) !!}
                                @endif
                            @endif
                            ';

//            <a href="#!" value="[$id]" onclick="eliminar(this)" data-toggle="modal" data-target="#modal-delete">
//            {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'label waves-effect waves-light red darken-1','value'=>"$id", 'data-toggle'=>'modal','data-target'=>'#modal-delete','onclick'=>"eliminar(this)"]) !!}

//            <a href="{{ route('admin.inscripcions.delete',[$id] ) }}" onclick="
//return  confirm('Confirme que desea borrar la inscripción?')">


            return Datatables::of($inscripciones)

                ->addColumn('actions', $action_buttons)

                ->addColumn('alumno', function (Inscripcion $inscripcion)  {
                    if ($inscripcion->alumno_id==0) {
                        return $inscripcion->factura->representante->persona->getNombreAttribute();
                    }else{
                        return $inscripcion->alumno->persona->getNombreAttribute();
                    }
                })->implode('<br>')

                //->filterColumn('alumno', function($query, $keyword) {
                //  $query->whereRaw("CONCAT(personas.nombres,'',personas.apellidos) like ?", ["%{$keyword}%"]);
                // })

                ->addColumn('ci_alumno', function (Inscripcion $inscripcion)  {
                    if ($inscripcion->alumno_id==0) {
                        return $inscripcion->factura->representante->persona->num_doc;
                    }else{
                        return $inscripcion->alumno->persona->num_doc;
                    }
                })->implode('<br>')

                //->filterColumn('ci_alumno', function($query, $keyword) {
                //  $query->whereRaw("personas.num_doc like ?", ["%{$keyword}%"]);
                //})

                ->addColumn('modulo', function (Inscripcion $inscripcion)  {
                    return $inscripcion->calendar->program->modulo->modulo;
                })->implode('<br>')

                ->addColumn('escenario', function (Inscripcion $inscripcion)  {
                    return $inscripcion->calendar->program->escenario->escenario;
                })->implode('<br>')

                ->addColumn('disciplina', function (Inscripcion $inscripcion)  {
                    return $inscripcion->calendar->program->disciplina->disciplina;
                })->implode('<br>')

                ->addColumn('dia', function (Inscripcion $inscripcion)  {
                    return $inscripcion->calendar->dia->dia;
                })->implode('<br>')

                ->addColumn('horario', function (Inscripcion $inscripcion)  {
                    return $inscripcion->calendar->horario->start_time.'-'. $inscripcion->calendar->horario->end_time;
                })->implode('<br>')

                ->addColumn('representante', function (Inscripcion $inscripcion)  {
                    return $inscripcion->factura->representante->persona->getNombreAttribute();
                })->implode('<br>')

                ->filterColumn('representante', function($query, $keyword) {
                    $query->whereRaw("CONCAT(personas.nombres,'',personas.apellidos) like ?", ["%{$keyword}%"]);
                })
                
                ->addColumn('ci_representante', function (Inscripcion $inscripcion)  {
                    return $inscripcion->factura->representante->persona->num_doc;
                })->implode('<br>')

                ->filterColumn('ci_representante', function($query, $keyword) {
                    $query->whereRaw("personas.num_doc like ?", ["%{$keyword}%"]);
                })

                ->make(true);
        }

        return view('campamentos.inscripcions.index');
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
        if (Auth::user()->hasRole(['planner', 'administrator','supervisor'])) {

            $inscripcion = Inscripcion::where('id', $id)->with('factura', 'calendar', 'user', 'alumno')->first();
//            $calendar = $inscripcion->calendar;
            $calendar_id = $inscripcion->calendar_id;
            $calendar = Calendar::findOrFail($calendar_id);
            $calendar->decrement('contador');

            $fact_id = $inscripcion->factura_id;
            $count_fact = Inscripcion::where('factura_id', '=', $fact_id)->count();

            if ($count_fact > 1) { //si es una inscripcion multiple

                for ($i=0;$i<$count_fact;$i++){ //eliminar cada inscripcion asociada
                    $inscripcion_m = Inscripcion::where('factura_id',$fact_id)->first();
                    $calendar = Calendar::findOrFail($inscripcion_m->calendar_id);
                    if ( ($calendar->contador)>0){
                        $calendar->decrement('contador');
                    }else{
                        Session::flash('message_danger', 'No hay Reservas para este curso ');
                        return redirect()->back();
                    }

                    $inscripcion_m->delete();
                }
                $descuento=Descuento::where('factura_id',$inscripcion->factura_id);
                $descuento->delete();
                $factura = Factura::where('id',$inscripcion->factura_id);
                $factura->delete();

                $tipo_inscripcion = 'multiple';
                Session::flash('message_danger', 'Reserva multiple, se eliminaron todas las reservas asociadas');
                return redirect()->back();

            } else { //inscripcion sencilla

                if ( ($calendar->contador)>0){
                    $calendar->decrement('contador');
                }else{
                    Session::flash('message_danger', 'No hay reservas para este curso ');
                    return redirect()->back();
                }
                $descuento=Descuento::where('factura_id',$inscripcion->factura_id);
                $descuento->delete();
                $factura = Factura::where('id',$inscripcion->factura_id);
                $factura->delete();
                $inscripcion->delete();
                Session::flash('message_danger', 'Reserva eliminada');
                return redirect()->route('admin.inscripcions.reservas');
            }
           
//            $inscripcion->delete();
//            $inscripcion->factura->delete();

           // Session::flash('message', 'Reserva eliminada');
//            return redirect()->back();


        } else return abort(403);
    }

    /**
     * Confirmar reserva
     * @param $id
     * @return mixed
     */
    public function reservaConfirm($id)
    {
        if (Auth::user()->hasRole(['planner', 'administrator','supervisor'])) {

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
                    if (is_null($user->escenario_id)){//online
                        $pto_cobro='N/A';
                    }else  $pto_cobro=$user->escenario_id;

                    $inscripcion = new Inscripcion();
                    $inscripcion->calendar()->associate($calendar);
                    $inscripcion->factura()->associate($factura);
                    $inscripcion->user()->associate($user);
                    $inscripcion->escenario()->associate($pto_cobro);

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
            if ($request->input('familiar') == 'on' && Session::get('curso')->totalCursos < 2) {
                Session::flash('message_danger', 'No se permiten menos de 2 inscripciones para el grupo Familiar');
                return redirect()->back();
            }

            //inscripcion multiples no puede tener menos de 3 inscritos y no puede ser en invierno
            if (($request->input('multiple') == 'on' && Session::get('curso')->totalCursos < 3)) {
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
                if (is_null($user->escenario_id)){//online
                    $pto_cobro='N/A';
                }else  $pto_cobro=$user->escenario_id;
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
                    if ($calendar->cupos < ($calendar->contador + $curso['qty'])) {//cupos no puede ser menor k la suma
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
                        $inscripcion->escenario()->associate($pto_cobro);
                        
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
    public function edit($id){

        $inscripcion = Inscripcion::where('id', $id)->with('factura', 'calendar', 'user', 'alumno','escenario')->first();
       
        //curso actual de la inscripcion seleccionada
        $curso_actual=Calendar::where('id',$inscripcion->calendar_id)->first();
        
        //costo actual de la inscripcion
        $costo_actual=$curso_actual->mensualidad;

        //edad del alumno
        if ($inscripcion->alumno_id == 0) { //si es inscripcion de adulto
           $edad=$inscripcion->factura->representante->getEdad($inscripcion->factura->representante->persona->fecha_nac);
        } else { //si es inscripcion de menor
            $edad=$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac);
        }

        $modulos_coll = Modulo::where('activated', true);
        $modulos = $modulos_coll->pluck('modulo', 'id');
        
        return view('campamentos.inscripcions.edit', compact('modulos', 'inscripcion','costo_actual','edad','curso_actual'));
        
    }

    
    /**
     * Buscar el curso para donde se quiere hacer el cambio en la inscripcion
     * @param Request $request
     * @return mixed
     */
    
    public function searchCurso(Request $request){
        
        
        $modulo = $request->get('modulo_id');
        $escenario = $request->get('escenario_id');
        $disciplina = $request->get('disciplina_id');
        $horario_id = $request->get('horario_id');
        $edad = $request->get('edad');
        $costo=$request->get('costo');
        $inscripcion_id=$request->get('inscripcion_id');

        $cursos = Calendar::with('program', 'horario', 'dia', 'profesor')
            ->join('programs as p', 'p.id', '=', 'c.program_id', 'as c')
            ->join('dias as d', 'd.id', '=', 'c.dia_id')
            ->join('horarios as h', 'h.id', '=', 'c.horario_id')
            ->join('escenarios as e', 'e.id', '=', 'p.escenario_id')
            ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
            ->join('disciplinas as dis', 'dis.id', '=', 'p.disciplina_id')
            ->join('profesors as pro', 'pro.id', '=', 'c.profesor_id')
            ->select('program_id', 'profesor_id', 'dia_id', 'c.horario_id', 'cupos', 'contador', 'mensualidad', 'init_age', 'end_age', 'nivel', 'c.id', 'p.modulo_id', 'p.escenario_id', 'p.disciplina_id','c.mensualidad')
            ->where('modulo_id', $modulo)
            ->where('escenario_id', $escenario)
            ->where('disciplina_id', $disciplina)
            ->whereIn('horario_id', $horario_id)
            ->where('p.activated', '1')
            ->get();

        return view('campamentos.calendars.filtrados.list_curso',compact('cursos','edad','costo','inscripcion_id'));
        
    }
    
   
    /**
     * Actualizar la inscripcion con el nuevo curso seleccionado
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateCurso(Request $request, $inscripcion_id,$curso)
    {
        
        if(Auth::user()->hasRole(['planner','administrator','supervisor'])) {

            try {

                DB::beginTransaction();

                //inscripcion a modificar
                $inscripcion=Inscripcion::where('id',$inscripcion_id)->with('factura','calendar','user','alumno')->first();

                //curso anterior que se desea modificar
                $curso_anterior=Calendar::findOrFail($inscripcion->calendar_id);

                //curso nuevo seleccionado
                $calendar = Calendar::findOrFail($curso);

                if ( ($calendar->mensualidad!=$inscripcion->calendar->mensualidad) ) {
                    Session::flash('message_danger', 'Los cursos tienen costos diferentes');
                    return redirect()->back();
                }

                if ( ($calendar->cupos - $calendar->contador)<=0 ) {
                    Session::flash('message_danger', 'No hay cupos para el curso seleccionado');
                    return redirect()->back();
                }

                //inscripcion
                $inscripcion->calendar()->associate($calendar);

                //usuario logueado que modifico
                $inscripcion->user_edit=$request->user()->id;

                $inscripcion->update();

                $curso_anterior->decrement('contador');//decremento cupo en el curso anterior
                $curso_anterior->update();

                $calendar->increment('contador');//incremento cupo en el nuevo curso
                $calendar->update();

                DB::commit();

                Session::flash('message', 'Actualización satisfactoria');

            } catch (\Exception $e) { //en caso de error viro al estado anterior
                DB::rollback();
//                Session::flash('message_danger', 'Error' . $e->getMessage());
                Session::flash('message_danger', 'Ocurrio un error y no se pudo realizar la acción');
                return redirect()->route('admin.inscripcions.index');
            }

            return redirect()->route('admin.inscripcions.index');
        }else
            return abort(403);
        
    }


    /**
     * Muestra el formulario para re-inscribir la inscripcion seleccionada en otro curso
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function reInscribirGet($id){

        $inscripcion = Inscripcion::where('id', $id)->with('factura', 'calendar', 'user', 'alumno','escenario')->first();

        //curso actual de la inscripcion seleccionada
        $curso_actual=Calendar::where('id',$inscripcion->calendar_id)->first();

        //familiar??
        $count_fact=Inscripcion::where('factura_id',$inscripcion->factura_id)->count();

        //costo actual de la inscripcion
        $costo_actual=$curso_actual->mensualidad;
        
        $factura_actual=$inscripcion->factura->total;

        //edad del alumno
        if ($inscripcion->alumno_id == 0) { //si es inscripcion de adulto
            $edad=$inscripcion->factura->representante->getEdad($inscripcion->factura->representante->persona->fecha_nac);
        } else { //si es inscripcion de menor
            $edad=$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac);
        }

        $modulos_coll = Modulo::where('activated', true);
        $modulos = $modulos_coll->pluck('modulo', 'id');

        return view('campamentos.inscripcions.re-inscribir', compact('modulos', 'inscripcion','costo_actual','edad','curso_actual','factura_actual','count_fact'));

    }

    /**
     * Buscar el curso nuevo  donde se quiere hacer la re-inscripcion
     * @param Request $request
     * @return mixed
     */

    public function searchNewCurso(Request $request){

        $modulo = $request->get('modulo_id');
        $escenario = $request->get('escenario_id');
        $disciplina = $request->get('disciplina_id');
        $horario_id = $request->get('horario_id');
        $edad = $request->get('edad');
        $costo=$request->get('costo');
       
        $cursos = Calendar::with('program', 'horario', 'dia', 'profesor')
            ->join('programs as p', 'p.id', '=', 'c.program_id', 'as c')
            ->join('dias as d', 'd.id', '=', 'c.dia_id')
            ->join('horarios as h', 'h.id', '=', 'c.horario_id')
            ->join('escenarios as e', 'e.id', '=', 'p.escenario_id')
            ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
            ->join('disciplinas as dis', 'dis.id', '=', 'p.disciplina_id')
            ->join('profesors as pro', 'pro.id', '=', 'c.profesor_id')
            ->select('program_id', 'profesor_id', 'dia_id', 'c.horario_id', 'cupos', 'contador', 'mensualidad', 'init_age', 'end_age', 'nivel', 'c.id', 'p.modulo_id', 'p.escenario_id', 'p.disciplina_id','c.mensualidad')
            ->where('modulo_id', $modulo)
            ->where('escenario_id', $escenario)
            ->where('disciplina_id', $disciplina)
            ->whereIn('horario_id', $horario_id)
            ->where('p.activated', '1')
            ->get();

        return view('campamentos.calendars.filtrados.list_new_curso',compact('cursos','edad','costo'));

    }

    /**
     * Actualizar la inscripcion con el nuevo curso seleccionado
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storeNewCurso(Request $request, $curso_id)
    {

        if (Auth::user()->hasRole(['planner', 'administrator', 'signup'])) {

            try {

                    DB::beginTransaction();
                    //curso
                    $calendar=Calendar::findOrFail($curso_id);

                    $program_id = $calendar->program_id; //programa
                    $program = Program::findOrFail($program_id);
                    $matricula = $program->matricula; //matricula del curso

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
                    if (is_null($user->escenario_id)){//online
                        $pto_cobro='N/A';
                    }else  $pto_cobro=$user->escenario_id;

                    $inscripcion = new Inscripcion();
                    $inscripcion->calendar()->associate($calendar);
                    $inscripcion->factura()->associate($factura);
                    $inscripcion->user()->associate($user);
                    $inscripcion->escenario()->associate($pto_cobro);

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

//            try {
//
//                DB::beginTransaction();
//
//                //inscripcion a modificar
//                $inscripcion=Inscripcion::where('id',$inscripcion_id)->with('factura','calendar','user','alumno')->first();
//
//                //curso anterior que se desea modificar
//                $curso_anterior=Calendar::findOrFail($inscripcion->calendar_id);
//
//                //curso nuevo seleccionado
//                $calendar = Calendar::findOrFail($curso);
//
//                if ( ($calendar->mensualidad!=$inscripcion->calendar->mensualidad) ) {
//                    Session::flash('message_danger', 'Los cursos tienen costos diferentes');
//                    return redirect()->back();
//                }
//
//                if ( ($calendar->cupos - $calendar->contador)<=0 ) {
//                    Session::flash('message_danger', 'No hay cupos para el curso seleccionado');
//                    return redirect()->back();
//                }
//
//                //inscripcion
//                $inscripcion->calendar()->associate($calendar);
//
//                //usuario logueado que modifico
//                $inscripcion->user_edit=$request->user()->id;
//
//                $inscripcion->update();
//
//                $curso_anterior->decrement('contador');//decremento cupo en el curso anterior
//                $curso_anterior->update();
//
//                $calendar->increment('contador');//incremento cupo en el nuevo curso
//                $calendar->update();
//
//                DB::commit();
//
//                Session::flash('message', 'Actualización satisfactoria');
//
//            } catch (\Exception $e) { //en caso de error viro al estado anterior
//                DB::rollback();
////                Session::flash('message_danger', 'Error' . $e->getMessage());
//                Session::flash('message_danger', 'Ocurrio un error y no se pudo realizar la acción');
//                return redirect()->route('admin.inscripcions.index');
//            }

//            return redirect()->route('admin.inscripcions.index');
//        }
            else
            return abort(403);

    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request,$id)
    {
        if(Auth::user()->hasRole(['planner','administrator','supervisor'])) {

            if ($request->ajax()) {

                $inscripcion = Inscripcion::where('id', $id)->with('factura', 'calendar', 'user', 'alumno')->first();

                $calendar_id = $inscripcion->calendar_id;
                $calendar = Calendar::findOrFail($calendar_id);

                $fact_id = $inscripcion->factura_id;
                $count_fact = Inscripcion::where('factura_id', '=', $fact_id)->count();

                if ($count_fact > 1) { //si es una inscripcion multiple

                    for ($i = 0; $i < $count_fact; $i++) { //eliminar cada inscripcion asociada
                        $inscripcion_m = Inscripcion::where('factura_id', $fact_id)->first();
                        $calendar = Calendar::findOrFail($inscripcion_m->calendar_id);
                        if (($calendar->contador) > 0) {
                            $calendar->decrement('contador');
                        } else {
                            $message='Ooops! parece que el curso tiene 0 cupos, por lo que no puede ser eliminado, contacte al admin.';
                            return  response()->json(['resp'=>$message]);
                        }
                        $inscripcion_m->delete();
                    }
                    $descuento = Descuento::where('factura_id', $inscripcion->factura_id);
                    $descuento->delete();
                    $factura = Factura::where('id', $inscripcion->factura_id);
                    $factura->delete();
                    $message='Inscripcion multiple, se eliminaron todas las inscripciones asociadas';
                    return response()->json(['resp'=>$message]);

                } else { //inscripcion sencilla

                    if (($calendar->contador) > 0) {
                        $calendar->decrement('contador');
                    } else {
                        $message='Ooops! parece que el curso tiene 0 cupos, por lo que no puede ser eliminado, contacte al admin.';
                        return  response()->json(['resp'=>$message]);
                    }
                    $descuento = Descuento::where('factura_id', $inscripcion->factura_id);
                    $descuento->delete();
                    $factura = Factura::where('id', $inscripcion->factura_id);
                    $factura->delete();
                    $inscripcion->delete();
                    $message='Inscripción eliminada';
                    return response()->json(['resp' => $message]);
                }
            }
        }else
            if ($request->ajax()){
                return response()->json(['resp'=>'No tiene permisos para realizar esta acción']);
            }else{
                return abort(403);
            }

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
