<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Dia;
use App\Disciplina;
use App\Escenario;
use App\Horario;
use App\Modulo;
use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Http\Requests\ProgramsStoreRequest;

class ProgramsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $programs = Program::
        join('escenarios as e', 'e.id', '=', 'p.escenario_id', 'as p')
            ->join('disciplinas as d', 'd.id', '=', 'p.disciplina_id')
            ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
            ->select('p.id', 'e.escenario', 'd.disciplina', 'm.modulo', 'matricula', 'p.activated', 'p.imagen')
//            ->where('p.activated',true)
            ->orderBy('e.escenario')->get();


        $programs->each(function ($programs) {
            $programs->calendars;
        });

        $array = [];
        foreach ($programs as $p) {
            $array[] = [
                'cupos' => Calendar::where('program_id', $p->id)->sum('contador'),
            ];
        }

        return view('campamentos.programs.index', compact('programs', 'array'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulos = [] + Modulo::where('activated', '1')->orderBy('modulo')->lists('modulo', 'id')->all();
        $escenarios = [] + Escenario::where('activated', '1')->orderBy('escenario')->lists('escenario', 'id')->all();
        $disciplinas = [] + Disciplina::where('activated', '1')->orderBy('disciplina')->lists('disciplina', 'id')->all();

        return view('campamentos.programs.create', compact('escenarios', 'disciplinas', 'modulos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramsStoreRequest $request)
    {
        if (Auth::user()->hasRole(['planner', 'administrator'])) {

            try {
                DB::beginTransaction();

                $program = new Program;
                $disciplina = $request->get('disciplina');
                $program->escenario_id = $request->get('escenario');
                $program->disciplina_id = $disciplina;
                $program->modulo_id = $request->get('modulo');
                $program->matricula = $request->get('matricula');
                $activated = true;
                $program->activated = $activated;

                if ($request->hasFile('imagen')) {
                    $file = $request->file('imagen');
                    $name = 'disciplina_' . $disciplina . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/img/camp/disciplinas/';
                    $file->move($path, $name);//lo copio a $path con el nombre $name
                    $program->imagen = $name;
                }

                $program->save();

                DB::commit();

                Session::flash('message', 'Programa creado');


            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('message_danger', 'Error' . $e->getMessage());
                return redirect()->route('admin.programs.create');
            }

            return redirect()->route('admin.programs.index');

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
        $program = Program::findOrFail($id);
        $disciplina = Disciplina::findOrFail($program->disciplina_id);
        $escenario = Escenario::findOrFail($program->escenario_id);
        $modulo = Modulo::findOrFail($program->modulo_id);
        $start = new Carbon($modulo->inicio);
        $end = new Carbon($modulo->fin);

        $estacion = '';
        if (($start->month >= 5) && ($start->month <= 12))
            $estacion = 'Verano';
        elseif (($start->month >= 1) && ($start->month < 3))
            $estacion = 'Verano';
        else
            $estacion = 'Invierno';

        $calendars = Calendar::
        join('dias as d', 'd.id', '=', 'cal.dia_id', 'as cal')
            ->join('horarios as h', 'h.id', '=', 'cal.horario_id')
            ->select('d.dia', 'h.start_time', 'h.end_time', 'cupos', 'contador', 'mensualidad', 'cal.id', 'cal.nivel', 'cal.init_age', 'cal.end_age')
            ->where('program_id', $id)
            ->get();

        return view('campamentos.programs.show', compact('program', 'disciplina', 'escenario', 'modulo', 'calendars', 'estacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $modulos = [] + Modulo::where('activated', '1')->orderBy('modulo', 'desc')->lists('modulo', 'id')->all();
        $escenarios = [] + Escenario::where('activated', '1')->lists('escenario', 'id')->all();
        $disciplinas = [] + Disciplina::lists('disciplina', 'id')->all();


        return view('campamentos.programs.edit', compact('program', 'escenarios', 'disciplinas', 'modulos'));
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
        if (Auth::user()->hasRole(['planner', 'administrator'])) {


            $program = Program::findOrFail($id);
            $disciplina = $request->get('disciplina_id');
            $program->escenario_id = $request->get('escenario_id');
            $program->disciplina_id = $disciplina;
            $program->modulo_id = $request->get('modulo_id');
            $program->matricula = $request->get('matricula');
            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $name = 'disciplina_' . $disciplina . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/img/camp/disciplinas/';
                $file->move($path, $name);//lo copio a $path con el nombre $name
                $program->imagen = $name;
            }
            $program->update();
            Session::flash('message', 'Programa acualizado');
            return redirect()->route('admin.programs.index');

        } else return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->hasRole(['administrator'])) {

            $program = Program::findOrFail($id);
            $program->delete();
            Session::flash('message', 'Programa eliminado');
            return back();

        } else return abort(403);
    }

    public function disable(Request $request, $id)
    {
        if (Auth::user()->hasRole(['planner', 'administrator'])) {
            $program = Program::findOrFail($id);
            $program->activated = false;
            $program->update();
            return back();

        } else return abort(403);
    }

    public function enable($id)
    {
        if (Auth::user()->hasRole(['planner', 'administrator'])) {

            $program = Program::findOrFail($id);
            $program->activated = true;
            $program->update();
            return back();

        } else return abort(403);
    }

    /**
     *
     * Obtener todos los escenarios activos por modulo para select dinamico,
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function getEscenarios(Request $request, $id)
    {

        if ($request->ajax()) {

            $modulo = Modulo::where('id', $id)->first();

            $inicio = $modulo->inicio;
            $inicio = new Carbon($inicio);
            $mes = $inicio->month;

            $escenarios = Program::
            join('escenarios as e', 'e.id', '=', 'p.escenario_id', 'as p')
                ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
                ->select('e.escenario as escenario','e.id as eID','p.modulo_id')
//                ->select('e.escenario as escenario', 'p.id as pID', 'e.id as eID', 'm.id as mID',
//                    'p.modulo_id', 'p.escenario_id', 'p.matricula')
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
     *
     * Obtener todos los escenarios activos por modulo para editar inscripcion,
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateEscenarios(Request $request, $insc, $id)
    {

        if ($request->ajax()) {

            $modulo = Modulo::where('id', $id)->first();

            $inicio = $modulo->inicio;
            $inicio = new Carbon($inicio);
            $mes = $inicio->month;

            $escenarios = Program::
            join('escenarios as e', 'e.id', '=', 'p.escenario_id', 'as p')
                ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
                ->select('e.escenario as escenario', 'p.id as pID', 'e.id as eID', 'm.id as mID',
                    'p.modulo_id', 'p.escenario_id', 'p.matricula')
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
                'inscripcion' => $insc,
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
//                ->select('e.escenario as escenario', 'p.id as pID', 'e.id as eID', 'm.id as mID', 'd.id as dID',
//                    'p.modulo_id', 'p.escenario_id', 'p.matricula', 'd.disciplina as disciplina', 'd.activated')
                ->select('d.id as dID', 'd.disciplina as disciplina', 'p.modulo_id', 'p.escenario_id', 'd.activated','p.activated')
                ->where('p.escenario_id', $escenario_id)
                ->where('p.modulo_id', $modulo_id)
                ->where('p.activated', '1')
                ->where('d.activated', '1')->groupBy('dID')->get()->toArray();

//            ->where('p.escenario_id',$id)
//                ->where('d.activated','1')->groupBy('dID')->get()->toArray();

//            $categoria = ['' => 'Seleccione la categoría'] + Categoria::lists('categoria', 'id')->all();
//            $escenar = $escenarios->pluck('escenario', 'escenario_id');

            return response($disciplinas);
        }
    }

    /**
     * Obtener las disciplina para un escenario  para select dinamico
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function updateDisciplinas(Request $request, $insc, $id)
    {

        if ($request->ajax()) {
            $disciplinas = Program::
            join('escenarios as e', 'e.id', '=', 'p.escenario_id', 'as p')
                ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
                ->join('disciplinas as d', 'd.id', '=', 'p.disciplina_id')
                ->select('e.escenario as escenario', 'p.id as pID', 'e.id as eID', 'm.id as mID', 'd.id as dID',
                    'p.modulo_id', 'p.escenario_id', 'p.matricula', 'd.disciplina as disciplina', 'd.activated')
                ->where('p.escenario_id', $id)
                ->where('d.activated', true)->groupBy('dID')->get()->toArray();


//            $categoria = ['' => 'Seleccione la categoría'] + Categoria::lists('categoria', 'id')->all();
//            $escenar = $escenarios->pluck('escenario', 'escenario_id');

            return response($disciplinas);
        }
    }

}
