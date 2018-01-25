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
use App\Persona;
use App\Program;
use App\Representante;
use App\User;
use App\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Event;
use Barryvdh\DomPDF\Facade as PDF;

use Yajra\Datatables\Datatables;


class PreInscripcionsController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es'); //fechas en español
//        $this->middleware('auth'); //debe estar logeado para acceder a este controlador
//        $this->middleware(['role:planner|administrator'], ['only' => ['update']]); //solo los roles planner y administrator pueden acceder al metodo update
//        $this->middleware(['role:administrator|supervisor|planner'], ['only' => ['destroy']]); //acceso al metodo destroy solo al los roles administrator, supervisor y planner
    }


    /** Muestra vista del formulario de preinscripcion online
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPreinscripcion()
    {
//        $modulos_coll = Modulo::where('activated', true)->get();
        $modulos_coll = Modulo::all();
        //filtro los modulos para extraer los que dicen permanente
        $mod = $modulos_coll->filter(function ($mod) {
            if (strpos($mod->modulo, 'PERMANENTE') == false) {
                return true; // true, el elemento se incluye, si retorna false, no se incluye
            }
        });
        $modulos = $mod->pluck('modulo', 'id');

        $fpagos_coll = Pago::all();
        //filtro las formas de pago
        $fp = $fpagos_coll->filter(function ($fp) {   //solo muestro los pagos CONTADO o WESTERN UNION
            if (strpos($fp->forma, 'CONTADO') !== false || strpos($fp->forma, 'WESTERN UNION') !== false) {
                return true; // true, el elemento se incluye, si retorna false, no se incluye
            }
        });
        $fpagos = $fp->pluck('forma', 'id');

        return view('online.preinscripcions.pre-inscripcion', compact('modulos', 'fpagos'));
    }

    /**
     *  Metodo para redirigir la busqueda del representante online
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function beforeSearch(Request $request)
    {
        $search = trim($request->get('datos'));
        if ($request->ajax()) {
            return redirect()->route('representatives.search', ['search' => $search]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Metodo que realiza la consulta en la bd
     * @param $search
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchRepresentatives($search)
    {

        $field = trim($search);
        if ($field != "") {

            $representantes = Persona::whereHas('representantes', function ($query) use ($field) {
                $query->where('num_doc', 'LIKE', '%' . $field . '%')
                    ->orWhere('nombres', 'LIKE', '%' . $field . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $field . '%');
            })
                ->orderBy('created_at', 'DESC')->get();

        }
        return view('online.preinscripcions.listSearch', compact('representantes'));

    }

    /**
     * Metodo que muestra la vista con los resultador de la busqueda
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listSearch()
    {
        return view('campamentos.alumnos.listSearch');
    }


    /**
     *  Obtener los alumnos para un representnate para select dinamico online
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getAlumnos(Request $request)
    {

        $repre_id = $request->get('repre_id');

        if ($request->ajax()) {

            $representante = Representante::with('persona')
                ->where('persona_id', $repre_id)->first();

            $trabajador = Worker::searchWorker($representante->persona->num_doc)->first();

            if ($trabajador)
                $descuento_empleado = true;
            else
                $descuento_empleado = false;

            $alumnos = Alumno::
            join('personas as p', 'p.id', '=', 'persona_id')
                ->select('alumnos.id as aID', 'p.nombres', 'p.apellidos')
                ->where('representante_id', $representante->id)
                ->get()->toArray();

            return response()->json([
                'alumnos' => $alumnos,
//                'representante'=>$representante,
                'descuento_empleado' => $descuento_empleado
            ]);
        }
    }

    /**
     *
     * Obtener todos los escenarios activos por modulo para select dinamico online,
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function getEscenarios(Request $request)
    {
        $id = $request->get('mod_id');

        if ($request->ajax()) {

            $modulo = Modulo::where('id', $id)->first();

            $inicio = $modulo->inicio;
            $inicio = new Carbon($inicio);
            $mes = $inicio->month;


            $escenarios = Program::
            join('escenarios as e', 'e.id', '=', 'p.escenario_id', 'as p')
                ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
                ->select('e.escenario as escenario', 'e.id as eID',
                    'p.modulo_id')
                ->where('p.modulo_id', $id)
                ->where('e.activated', '1')->groupBy('eID')->get();

//            $categoria = ['' => 'Seleccione la categoría'] + Categoria::lists('categoria', 'id')->all();
//            $escenar = $escenarios->pluck('escenario', 'escenario_id');

            if ($mes >= 5 && $mes <= 12)
                $estacion = 'VERANO';
            elseif ($mes >= 1 && $mes < 3)
                $estacion = 'VERANO';
            else
                $estacion = 'INVIERNO';

            return response()->json([
                'escenarios' => $escenarios,
                'estacion' => $estacion,

            ]);
        }
    }

    /**
     * Obtener las disciplina para un escenario  para select dinamico
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function getDisciplinas(Request $request)
    {
        if ($request->ajax()) {

            $escenario_id = $request->get('escenario');
            $modulo_id = $request->get('modulo');

            $disciplinas = Program::
            join('escenarios as e', 'e.id', '=', 'p.escenario_id', 'as p')
                ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
                ->join('disciplinas as d', 'd.id', '=', 'p.disciplina_id')
                ->select('p.escenario_id', 'p.modulo_id', 'd.activated', 'd.id as dID', 'd.disciplina as disciplina')
                ->where('p.escenario_id', $escenario_id)
                ->where('p.modulo_id', $modulo_id)
                ->where('d.activated', '1')->groupBy('dID')->get()->toArray();

            return response($disciplinas);
        }
    }

    /**
     *  Obtener los dias para un programa  con select dinamico
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getDias(Request $request)
    {

        if ($request->ajax()) {

            $escenario_id = $request->get('escenario');
            $disciplina_id = $request->get('disciplina');
            $modulo_id = $request->get('modulo');

            $program = Program::
            where('escenario_id', $escenario_id)
                ->where('disciplina_id', $disciplina_id)
                ->where('modulo_id', $modulo_id)->first();

            $dias = Calendar::
            join('dias as d', 'd.id', '=', 'c.dia_id', 'as c')
                ->select('d.dia as dias', 'd.activated', 'd.id as dID', 'c.dia_id', 'c.program_id')
                ->where('program_id', $program->id)
                ->where('d.activated', '1')->groupBy('dID')->get()->toArray();
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
    public function getHorario(Request $request)
    {

        if ($request->ajax()) {
            $escenario_id = $request->get('escenario');
            $disciplina_id = $request->get('disciplina');
            $modulo_id = $request->get('modulo');
            $dia_id = $request->get('dia_id');

            $program = Program::
            where('escenario_id', $escenario_id)
                ->where('disciplina_id', $disciplina_id)
                ->where('modulo_id', $modulo_id)->first();

            //Es adulto
            if ($request->input('alumno_id') == 'null' || !$request->input('alumno_id')) {
                $representante = Representante::where('persona_id', $request->input('representante_id'))->with('persona')->first();
                if (count($representante) > 0) {
                    $edad = $representante->getEdad($representante->persona->fecha_nac);
                } else {
                    $msg_error = "Para inscribir al adulto debe selecionar un representante";
                    return response(['msg_error' => $msg_error]);
                }
            } else { //es menor
                $alumno = Alumno::where('id', $request->input('alumno_id'))->with('persona')->first();
                if (count($alumno) > 0) {
                    $edad = $alumno->getEdad($alumno->persona->fecha_nac);
                } else {
                    $msg_error = "Debe selecionar un alumno";
                    return response(['msg_error' => $msg_error]);
                }
            }

            $horario = Calendar::
            join('horarios as h', 'h.id', '=', 'c.horario_id', 'as c')
                ->join('dias as d', 'd.id', '=', 'c.dia_id')
                ->select('h.start_time as start_time', 'h.end_time as end_time', 'h.activated', 'c.id as cID',
                    'h.id as hID', 'c.dia_id', 'c.horario_id', 'c.nivel', 'c.init_age', 'c.end_age')
                ->where('program_id', $program->id)
                ->where('c.dia_id', $dia_id)
                ->where(function ($query) use ($edad) {
                    $query->where('c.init_age', '<=', $edad)
                        ->where('c.end_age', '>=', $edad);
                })
                ->where('h.activated', '1')
                ->get()
                ->toArray();

            return response(['horario' => $horario, 'edad' => $edad]);
        }
    }

    /**
     * Obtener los niveles para el dia y horario del curso
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getNivel(Request $request)
    {
        if ($request->ajax()) {

            $escenario_id = $request->get('escenario');
            $disciplina_id = $request->get('disciplina');
            $modulo_id = $request->get('modulo');
            $dia_id = $request->get('dia_id');
            $horario_id = $request->get('horario_id');

            $program = Program::where('escenario_id', $escenario_id)
                ->where('disciplina_id', $disciplina_id)
                ->where('modulo_id', $modulo_id)->first();

            //Curso seleccionado, definido por el programa, el dia y los horarios
            $nivel = Calendar::
            where('program_id', $program->id)
                ->where('dia_id', $dia_id)
                ->where('horario_id', $horario_id)->get()->toArray();

            return response($nivel);
        }
    }

    /**
     * Obtener el curso al seleccionar el nivel
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getCurso(Request $request)
    {
        if ($request->ajax()) {

            $escenario_id = $request->get('escenario');
            $disciplina_id = $request->get('disciplina');
            $modulo_id = $request->get('modulo');
            $dia_id = $request->get('dia_id');
            $horario_id = $request->get('horario_id');
            $calendar_id = $request->get('calendar_id');//xk en el value del select de nivel estoy pasando el calendar_id
            $descuento_empleado = $request->get('descuento_empleado');

            $program = Program::where('escenario_id', $escenario_id)
                ->where('disciplina_id', $disciplina_id)
                ->where('modulo_id', $modulo_id)->first();

            $curso = Calendar::
            join('horarios as h', 'h.id', '=', 'c.horario_id', 'as c')
                ->join('dias as d', 'd.id', '=', 'c.dia_id')
                ->select('c.id as cID', 'c.program_id', 'c.cupos', 'c.contador')
                ->where('c.program_id', $program->id)
                ->where('c.id', $calendar_id)
                ->where('c.dia_id', $dia_id)
//                ->where('cupos','>','contador')
                ->where('c.horario_id', $horario_id)
                ->get()->toArray();

            $mensualidad = Calendar::
            select('mensualidad')
                ->where('id', $calendar_id)->first();

            $mes = $mensualidad->mensualidad;

            if ($descuento_empleado === true) {
                $desc = 0.5; //50%
                $descuento = $mes * $desc;
            } else $descuento = 0;

            $precio = $mes - $descuento;

            return response(["curso" => $curso, "precio" => number_format($precio, 2, '.', ' ')]);
        }
    }


    /**
     * Terminos y condiciones en pdf
     * @param $id
     * @return mixed
     */
    public function termsDownload(Request $request)
    {
//        set_time_limit(0);
//        ini_set('memory_limit', '1G');
        $pathtoFile = public_path() . '/dist/files/terminos y condiciones.docx';
        return response()->download($pathtoFile);

    }

    /**
     *  Guardar la preinscripcion online como una reserva
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
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

            $factura->descuento = $desc;

            $factura->save();

            if ($request->input('valor') == 0 && $request->input('cortesia') == 'on') {
                $descuentos = new Descuento();
                $descuentos->factura()->associate($factura);
                $descuentos->descripcion = 'CORTESIA';
                $descuentos->valor = $factura->descuento;
                $descuentos->save();
            }

            if ($request->input('descuento_empleado') == 'true' && $request->input('valor') > 0) {
                $descuentos = new Descuento();
                $descuentos->factura()->associate($factura);
                $descuentos->descripcion = 'DESCUENTO EMPLEADO';
                $descuentos->valor = $factura->descuento;
                $descuentos->save();
            }

            //inscripcion
//            $user = $request->user();//usuario logueado
            $user = User::where('email', 'western@mail.com')->first();
            if (is_null($user->escenario_id)) {//online
                $pto_cobro = 'N/A';
            } else  $pto_cobro = $user->escenario_id;

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

            $inscripcion->estado = 'Reservada'; //el estado de la reserva sera 'Reservada'

            $inscripcion->mensualidad = $mensualidad;

            $inscripcion->save();

            DB::commit();

            //aumentar contadores
            Event::fire(new NuevaInscripcion($calendar));//al guardar correctamenta la inscripcion llamao al evento de aumentar contador

            Session::flash('message', 'Inscripción satisfactoria');


        } catch (\Exception $e) { //en caso de error viro al estado anterior
            DB::rollback();
//            Session::flash('message_danger', 'Error' . $e->getMessage());
//            Session::flash('message_danger', 'Error al guardar la preinscripción');
            return redirect()->back();
        }

        return redirect()->route('preinscripcion.comprobante',$inscripcion);

    }

    /**
     * Comprobantes de pre-inscripcion en pdf
     * @param $id
     * @return mixed
     */
    public function pre_inscripcionPDF($id)
    {
        $inscripcion = Inscripcion::with('factura', 'calendar', 'user', 'alumno')
            ->where('id', $id)
            ->where('estado','Reservada')
            ->withCount('factura')
            ->first();
        setlocale(LC_TIME, 'es');
        $fecha_actual = Carbon::now();
        $month = $fecha_actual->formatLocalized('%B');//mes en español
        $day = $fecha_actual->format('d');
        $year = $fecha_actual->format('Y');
        $date = $fecha_actual->format('Y-m-d');

        set_time_limit(0);
        ini_set('memory_limit', '1G');

        $pdf = PDF::loadView('online.preinscripcions.pre-insc-comprobante', compact('inscripcion'));
        $pdf->setPaper(array(0,0,600,250));
//        return $pdf->download('ComprobantePago.pdf');//descarga el pdf
        return $pdf->stream('Comprobante preinscripcion');//imprime en pantalla

    }


}
