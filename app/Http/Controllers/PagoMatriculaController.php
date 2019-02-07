<?php

namespace App\Http\Controllers;

use App\Inscripcion;
use App\PagoMatricula;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
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

            $matriculas = PagoMatricula::with('inscripcion','inscripcion.calendar','inscripcion.calendar.dia','inscripcion.calendar.program','inscripcion.calendar.program.disciplina','inscripcion.calendar.program.escenario','inscripcion.calendar.program.modulo','factura','factura.representante','factura.representante.persona','user','escenario')
//                ->join('inscripcions', 'inscripcions.id', '=', 'pago_matriculas.inscripcion_id')
//                ->select('pago_matriculas.*', 'inscripcions.calendar_id')
            ;
//return dd($matriculas);
            $action_buttons = '
                             <a href="{{  route(\'admin.reports.matricula.pdf\',[$id] ) }}" target="_blank">
                                {!! Form::button(\'<i class="tiny fa fa-file-pdf-o"></i>\',[\'class\'=>\'label waves-effect waves-light orange accent-4\']) !!}
                               </a>
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
        //
    }
}
