<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Inscripcion;
use App\PagoMatricula;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use Yajra\Datatables\Datatables;

class PagoMatriculaController extends Controller
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
        return view('campamentos.inscripcions.matriculas.index');
    }


    public function getAll(Request $request)
    {


        if ($request->ajax()) {

            $inscripciones2 = Inscripcion::
            with('factura', 'calendar', 'user', 'alumno')
                ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
                ->join('programs', 'programs.id', '=', 'calendars.program_id')
                ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
                ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
                ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
                ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
                ->leftJoin('profesors', 'profesors.id', '=', 'calendars.profesor_id')
                ->join('dias', 'dias.id', '=', 'calendars.dia_id')
                ->join('facturas', 'facturas.id', '=', 'inscripcions.factura_id')
                ->join('representantes', 'representantes.id', '=', 'facturas.representante_id')
                ->join('personas', 'personas.id', '=', 'representantes.persona_id')
//                    ->join('alumnos','alumnos.id','=','inscripcions.alumno_id')
//                  ->join('personas','personas.id','=','alumnos.persona_id')
                ->select('inscripcions.id', 'inscripcions.alumno_id', 'inscripcions.factura_id', 'inscripcions.calendar_id', 'inscripcions.user_id', 'inscripcions.created_at', 'programs.disciplina_id', 'programs.escenario_id', 'modulos.modulo', 'inscripcions.escenario_id as pto_cobro', 'inscripcions.matricula', 'inscripcions.post_matricula')
                ->where('estado', 'Pagada')
                ->limit(30);

            $matriculas = PagoMatricula::with('inscripcion', 'inscripcion.calendar', 'inscripcion.calendar.dia', 'inscripcion.calendar.program', 'inscripcion.calendar.program.disciplina', 'inscripcion.calendar.program.escenario', 'inscripcion.calendar.program.modulo', 'factura', 'factura.representante', 'factura.representante.persona', 'user', 'escenario')
//                ->join('inscripcions', 'inscripcions.id', '=', 'pago_matriculas.inscripcion_id')
//                ->select('pago_matriculas.*', 'inscripcions.calendar_id')
            ;
//return dd($matriculas);
            $action_buttons = '
                             <a href="{{  route(\'admin.reports.matricula.pdf\',[$id] ) }}" target="_blank">
                                {!! Form::button(\'<i class="tiny fa fa-file-pdf-o"></i>\',[\'class\'=>\'label waves-effect waves-light orange accent-4\']) !!}
                               </a>
                                <!--Si tiene permisos para eliminar inscripciones-->
                                @if (Entrust::can(\'delete_inscripcion\')) 
                                <!--Si el usuario pertenece al escenario donde se realizo la inscripcion o es el planificador o admin-->
                                @if(Auth::user()->escenario_id==$escenario_id ||  Entrust::hasRole([\'planner\',\'administrator\']))
                                    {!! Form::button(\'<i class="tiny fa fa-trash-o" ></i>\',[\'class\'=>\'label waves-effect waves-light red darken-1\',\'value\'=>$id,\'onclick\'=>\'eliminar(this)\']) !!}
                                @endif
                            @endif
                            ';


//            <a href="#!" value="[$id]" onclick="eliminar(this)" data-toggle="modal" data-target="#modal-delete">
//            {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'label waves-effect waves-light red darken-1','value'=>"$id", 'data-toggle'=>'modal','data-target'=>'#modal-delete','onclick'=>"eliminar(this)"]) !!}

//            <a href="{{ route('admin.inscripcions.delete',[$id] ) }}" onclick="
//return  confirm('Confirme que desea borrar la inscripción?')">


            return Datatables::of($matriculas)
                ->addColumn('actions', $action_buttons)
                ->addColumn('modulo', function ($matricula) {
                    return $matricula->inscripcion->calendar->program->modulo->modulo;
                })
//                ->filterColumn('modulo', function ($query, $keyword) {
//                    $query->whereRaw("registros.numero = ?", ["{$keyword}"]);
//                })
                ->addColumn('representante', function ($matricula) {
                    return $matricula->factura->representante->persona->getNombreAttribute();
                })
                ->filterColumn('representante', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(personas.nombres,'',personas.apellidos) like ?", ["%{$keyword}%"]);
                })
                ->make(true);
        }

//        return view('campamentos.inscripcions.index');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {


        if (Auth::user()->hasRole(['planner', 'administrator', 'supervisor'])) {

            if ($request->ajax()) {

                $matricula = PagoMatricula::where('id', $id)->with('factura', 'inscripcion', 'user', 'escenario')->first();

                $today=Carbon::today();
                // agregar al dia de hoy el fin de la jornada hoy 18:00, hoy a las 6 pm
                $hoy= Carbon::create($today->year,$today->month,$today->day,18,0,0);

                // sumar a la fecha de creacion de la matricula 18 hrs para saber si se realizo en el dia de hoy hasta las 6 pm
                $mat_creada=$matricula->created_at->addHours(18); // para comparar que sea creado en el dia actual hasta las 6 pm 18:00

                // comparar si la fecha de hoy hasta las 6 pm es mayot o igual que la crecion de la matricula sumandole 18 hrs
                $realizada_hoy=$mat_creada->gte($hoy);

                // se realizo la matricula antes del dia de hoy (realizada_hoy=false), no se permite borrar por la facturacion si no es admin
                if (!$realizada_hoy && !Auth::user()->hasRole(['administrator'])){
                    return response()->json([
                        'resp' => 'EL usuario solo podrá eliminar matriculas creadas el mismo día por temas de facturación. Solo el administrador podrá eliminar esta matricula previa aprobación de tesoreria que debe enviar un correo electrónico al departamento de sistemas detallando las sgtes columnas de la matricula a eliminar: No. , No. inscripcion y Comprobante',
                        'estado'=>'error' ],200);
                }

                // elimino matricula y actualizo el usuario que la elimino
                if($matricula->delete()) {
                    $matricula = PagoMatricula::where('id', $id)->withTrashed()->first();
                    $matricula->user_delete = $request->user()->id;
                    $matricula->update();
                }

                $factura = Factura::where('id', $matricula->factura_id);
                $factura->delete();

                $message = 'Matricula eliminada';
                return response()->json(['resp' => $message],200);
            }

        } else
            if ($request->ajax()) {
                return response()->json(['resp' => 'No tiene permisos para realizar esta acción','estado'=>'error']);
            } else {
                return abort(403);
            }
    }
}
