<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Calendar;
use App\Cart;
use App\Dia;
use App\Disciplina;
use App\Escenario;
use App\Persona;
use App\Profesor;
use Carbon\Carbon;
use Event;
use App\Events\NuevaInscripcion;
use App\Factura;
use App\Horario;
use App\Inscripcion;
use App\Modulo;
use App\Multiples;
use App\Pago;
use App\Program;
use App\Representante;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Requests;
use App\Http\Requests\CalendarStoreRequest;


class CalendarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:administrator|planner'], ['only' => 'destroy']);//eliminar cursos solo administrador
        $this->middleware(['role:planner|supervisor|administrator'], ['only' => 'update']);//eliminar cursos
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $calendars=Calendar::
            join('programs as p','p.id','=','c.program_id','as c')
            ->join('dias as d','d.id','=','c.dia_id')
            ->join('horarios as h','h.id','=','c.horario_id')
            ->join('escenarios as e','e.id','=','p.escenario_id')
            ->join('modulos as m','m.id','=','p.modulo_id')
            ->join('disciplinas as dis','dis.id','=','p.disciplina_id')
            ->join('profesors as pro','pro.id','=','c.profesor_id')
            ->select('e.escenario','dis.disciplina','m.modulo','d.dia','h.start_time','h.end_time','cupos','contador',
                'mensualidad','c.id','c.init_age','c.end_age','c.nivel','pro.nombres','pro.apellidos','c.activated')
            ->where('p.activated','1')
            ->get();

        return view('campamentos.calendars.index',compact('calendars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {            
        $data =   $request->all();
        $program_id=key($data);
        $program=Program::findOrFail($program_id);
        $escenario_id=$program->escenario_id;
        $disciplina_id=$program->disciplina_id;
        $modulo_id=$program->modulo_id;
        $escenario=Escenario::findOrFail($escenario_id);
        $disciplina=Disciplina::findOrFail($disciplina_id);
        $modulo=Modulo::findOrFail($modulo_id);
       
        $horarios=[] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario'), 'id')->orderBy('start_time')->lists('horario','id')->all();
        $dias=[]+ Dia::orderBy('dia')->lists('dia','id')->all();
        $profesores=[] + Profesor::where('status',Profesor::ACTIVO)->select(DB::raw('CONCAT(nombres, " ", apellidos) AS nombre'), 'id')->orderBy('nombres')->lists('nombre','id')->all();
        
        return view('campamentos.calendars.create',compact('program','horarios','dias','escenario','disciplina','modulo','profesores'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarStoreRequest $request)
    {
        if(Auth::user()->hasRole(['planner','administrator'])){//administrador y planificador solo pueden crear cursos
            
        $calendar=new Calendar;
        $calendar->program_id=$request->get('program_id');
        $calendar->dia_id=$request->get('dia_id');
        $calendar->horario_id=$request->get('horario_id');
        $calendar->cupos=$request->get('cupos');
        $calendar->mensualidad=$request->get('mensualidad');
        $calendar->init_age=$request->get('init_age');
        $calendar->end_age=$request->get('end_age');
        $calendar->nivel=strtoupper($request->get('nivel'));
        $profe=Profesor::where('id',$request->get('profesor_id'))->first();
        $calendar->profesor()->associate($profe);
        $calendar->save();
        
        return redirect()->route('admin.programs.index');

        }else return abort(403);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calendar=Calendar::findOrFail($id);
        $program=Program::findOrFail($calendar->program_id);
        $escenario_id=$program->escenario_id;
        $disciplina_id=$program->disciplina_id;
        $modulo_id=$program->modulo_id;
        $escenario=Escenario::findOrFail($escenario_id);
        $disciplina=Disciplina::findOrFail($disciplina_id);
        $modulo=Modulo::findOrFail($modulo_id);
        $horarios=[] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario'), 'id')->lists('horario','id')->all();
        $dias=[]+ Dia::lists('dia','id')->all();
        $profesores=[] + Profesor::where('status',Profesor::ACTIVO)->select(DB::raw('CONCAT(nombres, " ", apellidos) AS nombre'), 'id')->lists('nombre','id')->all();

        return view('campamentos.calendars.edit',compact('calendar','horarios','dias','escenario','disciplina','modulo','profesores'));
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
        if(Auth::user()->hasRole(['planner','administrator'])){//solo pueden modificar los cursos el planificador y el administrador
            
        $calendar=Calendar::findOrFail($id);
        $calendar->dia_id=$request->get('dia_id');
        $calendar->horario_id=$request->get('horario_id');
        $calendar->cupos=$request->get('cupos');
        $calendar->mensualidad=$request->get('mensualidad');
        $calendar->init_age=$request->get('init_age');
        $calendar->end_age=$request->get('end_age');
        $calendar->nivel=strtoupper($request->get('nivel'));
        $profe=Profesor::where('id',$request->get('profesor_id'))->first();
        $calendar->profesor()->associate($profe);
        $calendar->update();
        return redirect()->back();
        }else return abort(403);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($calendar)
    {
        if (Auth::user()->hasRole(['administrator'])) {

            $curso = Calendar::findOrFail($calendar);
            $insc=Inscripcion::where('calendar_id',$calendar)->first();

            if ($insc){
                Session::flash('message_danger', 'No es posible eliminar el curso porque tiene inscripciones');
                return redirect()->back();
            }
            $curso->delete();
            Session::flash('message', 'Curso eliminado');
            return back();

        } else return abort(403);

    }

    public function disable(Request $request, $id)
    {
        if (Auth::user()->hasRole(['planner', 'administrator'])) {
            $calendar = Calendar::findOrFail($id);
            $calendar->activated = false;
            $calendar->update();
            return back();

        } else return abort(403);
    }

    public function enable($id)
    {
        if (Auth::user()->hasRole(['planner', 'administrator'])) {

            $calendar = Calendar::findOrFail($id);
            $calendar->activated = true;
            $calendar->update();
            return back();

        } else return abort(403);
    }

    /**
     *  Obtener los dias para un programa  con select dinamico
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getDias(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            if ($request->input('alumno_id')=='null' || !$request->input('alumno_id')){
                $representante=Representante::where('persona_id',$request->input('representante_id'))->with('persona')->first();
                $edad=$representante->getEdad($representante->persona->fecha_nac); //edad del representante, insc de adulto
                $anio_nac = Persona::getAnioNacimiento($representante->persona->fecha_nac);

            }else {
                $alumno=Alumno::where('id',$request->input('alumno_id'))->with('persona')->first();
                $edad=$alumno->getEdad($alumno->persona->fecha_nac); //edad del alumno inscrito
                $anio_nac = Persona::getAnioNacimiento($alumno->persona->fecha_nac);
            }

            $modulo=Modulo::where('id',$modulo_id)->first();
            if ($modulo->esRiver()){
                if ($request->input('alumno_id')=='null' || !$request->input('alumno_id')) {
                    $anio_nac = Persona::getAnioNacimiento($representante->persona->fecha_nac);
                }else{
                    $anio_nac = Persona::getAnioNacimiento($alumno->persona->fecha_nac);
                }
                $dias=Calendar::
                join('dias as d','d.id','=','c.dia_id','as c')
                    ->select('d.dia as dias','d.activated','c.id as cID','d.id as dID',
                        'c.dia_id','c.horario_id','c.nivel','c.program_id')
                    ->where('program_id',$program->id)
                    ->where('d.activated','1')
//                    ->where('cupos','>','contador')
                    ->whereRaw('cupos > contador')
                    ->where(function ($query) use ($anio_nac) {
                        $query->where('c.init_age', '<=', $anio_nac)
                            ->where('c.end_age', '>=', $anio_nac);
                    })
                    ->groupBy('dID')
                    ->get()
                    ->toArray();
//                return response($dias);
                return response(['dias'=>$dias,'edad'=>$edad,'river'=>true,'anio_nac'=>$anio_nac]);
            }

            $dias=Calendar::
            join('dias as d','d.id','=','c.dia_id','as c')
                ->select('d.dia as dias','d.activated','c.id as cID','d.id as dID',
                    'c.dia_id','c.horario_id','c.nivel','c.program_id')
                ->where('program_id',$program->id)
                ->where('d.activated','1')
                ->whereRaw('cupos > contador')
//                ->where('cupos','>','contador')
                ->where(function ($query) use ($edad) {
                    $query->where('c.init_age', '<=', $edad)
                        ->where('c.end_age', '>=', $edad);
                })
                ->groupBy('dID')
                ->get()
                ->toArray();
//            return response($dias);
            return response(['dias'=>$dias,'edad'=>$edad,'river'=>false,'anio_nac'=>$anio_nac]);

        }
    }


    /** VER XK NO SE ESTA UTILIZANDO
     *  Obtener los dias para un programa  con select dinamico para editar inscripcion
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateDias(Request $request){

        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();
            $dias=Calendar::
            join('dias as d','d.id','=','c.dia_id','as c')
                ->select('d.dia as dias', 'd.activated','c.dia_id','c.program_id','d.id as dID','c.activated')
                ->where('program_id',$program->id)
                ->where('c.activated','1')
                ->where('d.activated','1')->groupBy('dID')->get()->toArray();
            return response($dias);

        }
    }
    
    /**
     * Obtener horarios para los dias
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getHorario(Request $request){

        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');

            $modulo=Modulo::where('id',$modulo_id)->first();

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            if ($request->input('alumno_id')=='null' || !$request->input('alumno_id')){
                $representante=Representante::where('persona_id',$request->input('representante_id'))->with('persona')->first();
                $edad=$representante->getEdad($representante->persona->fecha_nac); //edad del representante, insc de adulto
                $anio_nac = Persona::getAnioNacimiento($representante->persona->fecha_nac);

            }else {
                $alumno=Alumno::where('id',$request->input('alumno_id'))->with('persona')->first();
                $edad=$alumno->getEdad($alumno->persona->fecha_nac); //edad del alumno inscrito
                $anio_nac = Persona::getAnioNacimiento($alumno->persona->fecha_nac);
            }

            // En los modulos de River plate se comprueba el año de nacimiento, no la edad
            if ($modulo->esRiver()){

                if ($request->input('alumno_id')=='null' || !$request->input('alumno_id')) {
                    $anio_nac = Persona::getAnioNacimiento($representante->persona->fecha_nac);
                }else{
                    $anio_nac = Persona::getAnioNacimiento($alumno->persona->fecha_nac);
                }

                $horario=Calendar::
                join('horarios as h','h.id','=','c.horario_id','as c')
                    ->join('dias as d','d.id','=','c.dia_id')
                    ->select('c.horario_id', 'h.start_time as start_time','h.end_time as end_time','c.init_age','c.end_age','c.activated',
                        'h.activated','c.dia_id','c.program_id')
                    ->where('program_id',$program->id)
                    ->where('h.activated','1')
                    ->where('c.activated','1')
                    ->where('c.dia_id',$dia_id)
                    ->where(function ($query) use ($anio_nac) {
                        $query->where('c.init_age', '<=', $anio_nac)
                            ->where('c.end_age', '>=', $anio_nac);
                    })
                    ->get()
                    ->toArray();

                return response(['horario'=>$horario,'edad'=>$edad,'river'=>true,'anio_nac'=>$anio_nac]);
            }

            $horario=Calendar::
                join('horarios as h','h.id','=','c.horario_id','as c')
                ->join('dias as d','d.id','=','c.dia_id')
                ->select('c.horario_id', 'h.start_time as start_time','h.end_time as end_time','c.init_age','c.end_age','c.activated',
                    'h.activated','c.dia_id','c.program_id')
                ->where('program_id',$program->id)
                ->where('c.dia_id',$dia_id)
                ->where(function ($query) use ($edad) {
                    $query->where('c.init_age', '<=', $edad)
                        ->where('c.end_age', '>=', $edad);
                })
                ->where('h.activated','1')
                ->where('c.activated','1')
                ->get()
                ->toArray();
            return response(['horario'=>$horario,'edad'=>$edad,'river'=>false,'anio_nac'=>$anio_nac]);
        }
    }


    /**
     * Obtener horarios para los dias para editar inscripcion
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateHorario(Request $request){

        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');

            $modulo=Modulo::where('id',$modulo_id)->first();

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();


            if ($request->input('alumno_id')=='null' || !$request->input('alumno_id')){
                $representante=Representante::where('persona_id',$request->input('representante_id'))->with('persona')->first();
                $edad=$representante->getEdad($representante->persona->fecha_nac);
                $anio_nac = Persona::getAnioNacimiento($representante->persona->fecha_nac);

            }else {
                $alumno=Alumno::where('id',$request->input('alumno_id'))->with('persona')->first();
                $edad=$alumno->getEdad($alumno->persona->fecha_nac);
                $anio_nac = Persona::getAnioNacimiento($alumno->persona->fecha_nac);
            }

            if ($modulo->esRiver()){

                if ($request->input('alumno_id')=='null' || !$request->input('alumno_id')) {
                    $anio_nac = Persona::getAnioNacimiento($representante->persona->fecha_nac);
                }else{
                    $anio_nac = Persona::getAnioNacimiento($alumno->persona->fecha_nac);
                }

                $horario=Calendar::
                join('horarios as h','h.id','=','c.horario_id','as c')
                    ->join('dias as d','d.id','=','c.dia_id')
                    ->select('c.horario_id', 'h.start_time as start_time','h.end_time as end_time','c.init_age','c.end_age','c.activated',
                        'h.activated','c.dia_id','c.program_id')
                    ->where('program_id',$program->id)
                    ->where('h.activated','1')
                    ->where('c.activated','1')
                    ->where('c.dia_id',$dia_id)
                    ->where(function ($query) use ($anio_nac) {
                        $query->where('c.init_age', '<=', $anio_nac)
                            ->where('c.end_age', '>=', $anio_nac);
                    })
                    ->get()
                    ->toArray();

                return response(['horario'=>$horario,'edad'=>$edad,'river'=>true,'anio_nac'=>$anio_nac]);
            }

            $horario=Calendar::
            join('horarios as h','h.id','=','c.horario_id','as c')
                ->join('dias as d','d.id','=','c.dia_id')
                ->select('h.start_time as start_time','h.end_time as end_time','h.activated','c.id as cID',
                    'h.id as hID','c.dia_id','c.horario_id','c.nivel', 'c.init_age','c.end_age')
                ->where('program_id',$program->id)
                ->where('c.dia_id',$dia_id)
                ->where(function ($query) use ($edad) {
                    $query->where('c.init_age', '<=', $edad)
                        ->where('c.end_age', '>=', $edad);
                })
                ->where('h.activated','1')
                ->get()
                ->toArray();

            return response(['horario'=>$horario,'edad'=>$edad,'river'=>false,'anio_nac'=>$anio_nac]);
        }
    }

    /**
     * Obtener los niveles
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getNivel(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');
            $horario_id=$request->get('horario_id');

            $modulo=Modulo::where('id',$modulo_id)->first();

            $river=false;
            if ($modulo->esRiver()){
                $river=true;
                //modulo en que esta inscrito anteriormente en el presente año

            }

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            $nivel=Calendar::
               where('program_id',$program->id)
                ->where('dia_id',$dia_id)
                ->whereRaw('cupos > contador')
                ->where('horario_id',$horario_id)->get()->toArray();

            if (count($nivel)>0)
            {
                return response(['nivel'=>$nivel,'river'=>$river]);
            }
            return response()->json('error');
        }
    }


    /**
     * Obtener los niveles para editar inscripcion
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateNivel(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');
            $horario_id=$request->get('horario_id');

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            $nivel=Calendar::
            where('program_id',$program->id)
                ->where('dia_id',$dia_id)
                ->where('horario_id',$horario_id)->get()->toArray();
            
            return response($nivel);
        }
    }


    /**
     * Obtener el curso o calendario del formulario de inscripcion
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getCurso(Request $request){
        if ($request->ajax()){

            $calendar_id=$request->get('nivel');//xk en el value del select de nivel estoy pasando el calenadr_id

            $curso=Calendar::where('id',$calendar_id)->first();

            if ($curso){
                return response($curso);
            }
            return response()->json('error');

        }
    }

    /**
     * Obtener el curso o calendario del formulario para editar la inscripcion
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateCurso(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');
            $horario_id=$request->get('horario_id');
            $calendar_id=$request->get('nivel');//xk en el value del select de nivel estoy pasando el calenadr_id

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            $calendar=Calendar::findOrFail($calendar_id);

            $curso=Calendar::
            join('horarios as h','h.id','=','c.horario_id','as c')
                ->join('dias as d','d.id','=','c.dia_id')
                ->select('c.id as cID','c.program_id','c.cupos','c.contador')
                ->where('c.program_id',$program->id)
                ->where('c.id',$calendar_id)
                ->where('c.dia_id',$dia_id)
                ->whereRaw('cupos > contador')
                ->where('c.horario_id',$horario_id)
                ->get()->toArray();

            return response($curso);
        }
    }
        
    /*****PRODUCTO venta del curso*****/
    /**
     * Adicionar Cursos a la clase Multiple al dar en el boton de (+), multiple, familiar, primo, etc
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function getAddCurso(Request $request,$id){


        $curso=Calendar::where('id',$id)->with('horario','dia','program')->first(); //obtengo el curso, actual inscripcion

        $desc_emp=$request->input('descuento_empleado'); //si es empleado o no, true or false
        
        $representante=Representante::where('persona_id',$request->input('representante_id'))->with('persona')->first();
        
        $matricula=$request->input('matricula'); //true or false

        $paga_matricula_river = $request->input('matricula_river'); //paga o no mebresia river true or false

        $cancelado_mensual = $request->input('valor');


        $familiar=$request->input('familiar');//on or off,  10% familiares hermanos
        $primo=$request->input('primo');//on or off,  5% primos
        $multiple=$request->input('multiple');//on or off, 10% inscripcion en mismo curso 3 meses o mas

        $tipo_desc='';
        if ($familiar=='on')
            $tipo_desc='familiar';
        if ($multiple=='on')
            $tipo_desc='multiple';
        if ($primo=='on')
            $tipo_desc='primo';

        if ($request->input('adulto')=='on'){
            $alumno=$representante;
        }else {
            $alumno=Alumno::where('id',$request->input('alumno_id'))->with('persona')->first();
        }

        $opciones[]=[
            'tipo_desc'=>$tipo_desc,
            'desc_emp'=>$desc_emp,
            'set_matricula'=>$matricula,
            'alumno'=>$alumno,
            'representante'=>$representante,
            'paga_matricula_river' => $paga_matricula_river,
            'cancelado_mensual' => $cancelado_mensual,
        ];

        //si hay un curso almacenado en la session lo tomo, sino le paso nulo
        $oldCurso=Session::has('curso') ? Session::get('curso') : null;
        //creo una instancia de la coleccion de cursos
        $multiples=new Multiples($oldCurso);
        $multiples->addCursos($curso,$curso->id,$opciones);//Agrego este curso a la coleccion de cursos o carrito
        //pongo el curso en la session
        $request->session()->put('curso',$multiples);//idem a Session::put('curso',$multiples)
//        return response()->json($request->session()->get('curso'));
//        dd($request->session()->get('curso')); //idem a Session::get('curso')
        $message='Curso agregado a la colección';
        if ($request->ajax()){
            return response()->json([
                'message'=>$message,
                'totalCursos'=>Session::get('curso')->totalCursos,//para agregarlos en el indicador al lado de Detalles
            ]);
        }
            return redirect()->route('admin.inscripcions.create');
        
    }

    /**
     * Mostrar el detalle (carrito) de la coleccion de cursos
     *
     * @param Request $request
     * @return mixed
     */
    public function getCursos(Request $request)
    {
//        Session::forget('curso');
        if (!Session::has('curso')){

            return view('campamentos.inscripcions.create');
        }
        $oldCurso=Session::get('curso');//obtengo el curso que tenga en la session
        
        $cursos_coll=new Multiples($oldCurso);

        $cursos=$cursos_coll->cursos; //objeto curso dentro del arreglo
        $precioTotal=$cursos_coll->totalPrecio; //suma de todas las mensualidades de los cursos en el carrito
        $tipo_desc=$cursos_coll->tipo_desc; //si es decuento familiar primo o multiple
        $desc_emp=$cursos_coll->desc_empleado; //si es des por empleado
        $matriculaTotal=$cursos_coll->totalMatricula; //suma de todas las matriculas de los cursos en el carrito

//        $matricula=0;
//        foreach ($cursos as $curso){
//            $matricula+=$curso['matricula']; //costo de la matricula en caso que aplique
//        }

        $descuento=0;
        if ($desc_emp=='true'){
            $desc=0.5; //50% empleado
            $descuento= $precioTotal*$desc; //mensualidadTotal*desc_empleado 
            $tipo_desc='empleado';
        }else if ($tipo_desc=='familiar' || $tipo_desc=='multiple'){
            $desc=0.1; //10% desc hermanos y multiple
            $descuento=$precioTotal*$desc; //mensualidadTotal*desc
        }else if ($tipo_desc=='primo'){
            $desc=0.05; //5% desc primos
            $descuento=$precioTotal*$desc; //mensualidadTotal*desc
        }

        $subTotal=$precioTotal + $matriculaTotal; //mensualidadTotal + matriculaTotal

        $total=$subTotal-$descuento; //total aplicado los descuentos


        return view('campamentos.inscripcions.partials.detalle',compact('cursos','descuento','total','tipo_desc','subTotal','precioTotal','matriculaTotal'));
    }

    /**
     * Quitar 1 solo curso de la coleccion, uno a uno
     * @param $id
     * @return mixed
     */
    public function getRestarUno($id){
        
        $oldCurso=Session::has('curso') ? Session::get('curso') : null;
        
        $curso=new Multiples($oldCurso);
        
        $curso->restarUno($id);//restarUno($id), metodo de la clase Multiple

        if (count($curso->cursos)>0){ //si quedan cursos en el carrito
            Session::put('curso',$curso); //lo pngo en la session
        }else{
            Session::forget('curso'); //sino limpio la session
        }
        return redirect()->route('admin.inscripcions.create'); 
    }


    /**
     * Eliminar el item de curso completo 
     *
     * @param $id
     * @return mixed
     */

    public function getRestarCurso($id){
        
        $oldCurso=Session::has('curso') ? Session::get('curso') : null;
        
        $curso=new Multiples($oldCurso);
        
        $curso->restarTodos($id); //restarTodos($id), metodo de la clase Multiple

        if (count($curso->cursos)>0){
            Session::put('curso',$curso);
        }else{
            Session::forget('curso');
        }
        return redirect()->route('admin.inscripcions.create');
    }


    
    //Ver para inscripcion online
    /**
     * Realizar el pago online
     * @param Request $request
     * @return mixed
     */
    public function postStore(Request $request)
    {
       //  guardar los cursos de la session

        $oldCurso=Session::get('curso');
        $cart=new Multiples($oldCurso);

        $cursos=$cart->cursos;
        $precioTotal=$cart->totalPrecio;
        $tipo_descuento=$cart->tipo_desc;
        $desc_emp=$cart->desc_empleado;
        
        if ($tipo_descuento=='familiar' || $tipo_descuento=='multiple'){
            $desc1=0.1;
        } else  $desc1=0;

        if ($desc_emp=='true'){
            $desc2=0.5;
        }else  $desc2=0;

        if ($tipo_descuento=='primo'){
            $desc3=0.05;
        }else  $desc3=0;

        $descuento=$precioTotal*$desc1 + $precioTotal*$desc2 +$precioTotal*$desc3;;

        $total=$precioTotal-$descuento;


        try {
            //almacenando la informacion de la orden en mi bd
            $inscripcion=new Inscripcion();
            $inscripcion->cart=serialize($cart);//serializo el objeto cart, para guaradrlo como string en la bd
            
                        
            Auth::user()->inscripcion->save($inscripcion);
        }catch(\Exception $e){
            return redirect()->route('admin.inscripcions.create')->with('message_danger',$e->getMessage());
        }

        Session::forget('curso');//limpiando la session, vaciando el carrito
        return redirect()->route('admin.inscripcions.index')->with('message','Inscripcion satisfactoria');
    }



//    /**
//     * Obtengo la vista para la facturacion y hacer el pago
//     *
//     * @return mixed
//     *
//     */
//    public function getCheckout()
//    {
//        if (!Session::has('cart')){
//            return redirect()->route('admin.inscripcions.create');
//        }
//        $oldCart=Session::get('cart');
//        $cart=new Cart($oldCart);
//        $total=$cart->totalPrice;
//        return view('shop.checkout',['total'=>$total]);
//    }
//


//    /**
//     * Realizar el pago online
//     * @param Request $request
//     * @return mixed
//     */
//    public function postCheckout(Request $request)
//    {
//        if (!Session::has('cart')){
//            return redirect()->route('shopppingCart');
//        }
//        $oldCart=Session::get('cart');
//        $cart=new Cart($oldCart);
//        Stripe::setApiKey('sk_test_yXZNh4Iswaypk4Jq2i9UugiP');//my test secret key for stripe
//        try {
//            //cargando la ordena a stripe
//            //tomado de stripe, multiplicar *100 para que tenga en cuenta las centenas
//            $charge=Charge::create(array(
//                "amount" => $cart->totalPrice*100,
//                "currency" => "usd",
//                "source" => $request->input('stripeToken'), // obtained with Stripe.js
//                "description" => "Charge for james.smith@example.com"
//            ));
//            //almacenando la informacion de la orden en mi bd
//            $order=new Order();
//            $order->cart=serialize($cart);//serializo el objeto cart, para guaradrlo como string en la bd
//            $order->address=$request->input('address');
//            $order->name=$request->input('name');
//            $order->payment_id=$charge->id; //tomo el id del response del stripe
//            //Guardar en la bd segun la relacion establecida entre el usuario y la orden.
//
//            Auth::user()->orders()->save($order);
//        }catch(\Exception $e){
//            return redirect()->route('checkout')->with('error',$e->getMessage());
//        }
//
//        Session::forget('cart');//limpiando la session, vaciando el carrito
//        return redirect()->route('product.index')->with('success','Compra satisfactoria del producto');
//    }

}
