<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Dia;
use App\Disciplina;
use App\Escenario;
use App\Horario;
use App\Modulo;
use App\Program;
use Illuminate\Http\Request;
use DB;
use Session;

use App\Http\Requests\ProgramsStoreRequest;

class ProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $programs=Program::
            join('escenarios as e','e.id','=','p.escenario_id','as p')
            ->join('disciplinas as d','d.id','=','p.disciplina_id')
            ->join('modulos as m','m.id','=','p.modulo_id')
            ->select('p.id','e.escenario','d.disciplina','m.modulo','matricula','cuposT','p.activated')
            ->where('p.activated',true)
            ->orderBy('e.escenario')->get();

       return view('campamentos.programs.index',compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulos=[] + Modulo::where('activated','1')->orderBy('modulo', 'desc')->lists('modulo', 'id')->all();
        $escenarios=[] + Escenario::where('activated','1')->lists('escenario', 'id')->all();
        $disciplinas=[] + Disciplina::lists('disciplina', 'id')->all();
      
        return view('campamentos.programs.create',compact('escenarios','disciplinas','modulos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramsStoreRequest $request)
    {
        $program=new Program;
        $program->escenario_id=$request->get('escenario');
        $program->disciplina_id=$request->get('disciplina');
        $program->modulo_id=$request->get('modulo');
        $program->matricula=$request->get('matricula');
        $program->cuposT=$request->get('cuposT');
        $activated=true;
        $program->activated=$activated;
        $program->save();
        Session::flash('message','Programa creado');
        return redirect()->route('admin.programs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program=Program::findOrFail($id);
        $disciplina=Disciplina::findOrFail($program->disciplina_id);
        $escenario=Escenario::findOrFail($program->escenario_id);
        $modulo=Modulo::findOrFail($program->modulo_id);
        $calendars=Calendar::
            join('dias as d','d.id','=','cal.dia_id','as cal')
            ->join('horarios as h','h.id','=','cal.horario_id')
            ->select('d.dia','h.start_time','h.end_time','cupos','contador','mensualidad','cal.id')
            ->where('program_id',$id)
            ->get();
        
        return view('campamentos.programs.show',compact('program','disciplina','escenario','modulo','calendars'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program=Program::findOrFail($id);
        $modulos=[] + Modulo::where('activated','1')->orderBy('modulo', 'desc')->lists('modulo', 'id')->all();
        $escenarios=[] + Escenario::where('activated','1')->lists('escenario', 'id')->all();
        $disciplinas=[] + Disciplina::lists('disciplina', 'id')->all();


        return view('campamentos.programs.edit',compact('program','escenarios','disciplinas','modulos'));
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
        $program=Program::findOrFail($id);
        $program->escenario_id=$request->get('escenario_id');
        $program->disciplina_id=$request->get('disciplina_id');
        $program->modulo_id=$request->get('modulo_id');
        $program->matricula=$request->get('matricula');
        $program->cuposT=$request->get('cuposT');
        $program->update();
        Session::flash('message','Programa acualizado');
        return redirect()->route('admin.programs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program=Program::findOrFail($id);
        $program->delete();
        Session::flash('message','Programa eliminado');
        return back();
    }

    public function disable(Request $request,$id)
    {
        $program=Program::findOrFail($id);
        $program->activated=false;
        $program->update();
        return back();
    }

    public function enable($id)
    {
        $program=Program::findOrFail($id);
        $program->activated=true;
        $program->update();
        return back();
    }

    /**
     *
     * Obtener todos los escenarios activos por modulo para select dinamico,
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function getEscenarios(Request $request,$id){

        if ($request->ajax()){

                $escenarios=Program::
                    join('escenarios as e','e.id','=','p.escenario_id','as p')
                    ->join('modulos as m','m.id','=','p.modulo_id')
                    ->select('e.escenario as escenario','p.id as pID','e.id as eID','m.id as mID',
                    'p.modulo_id','p.escenario_id')
                    ->where('p.modulo_id',$id)
                    ->where('e.activated',true)->groupBy('eID')->get()->toArray();

//            $categoria = ['' => 'Seleccione la categoría'] + Categoria::lists('categoria', 'id')->all();
//            $escenar = $escenarios->pluck('escenario', 'escenario_id');

            return response($escenarios);
        }
    }

    /**
     * Obtener las disciplina para un escenario  para select dinamico
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function getDisciplinas(Request $request,$id){

        if ($request->ajax()){

            $disciplinas=Program::
                join('escenarios as e','e.id','=','p.escenario_id','as p')
                ->join('modulos as m','m.id','=','p.modulo_id')
                ->join('disciplinas as d','d.id','=','p.disciplina_id')
                ->select('e.escenario as escenario','p.id as pID','e.id as eID','m.id as mID','d.id as dID',
                    'p.modulo_id','p.escenario_id','d.disciplina as disciplina','d.activated')
                ->where('p.escenario_id',$id)
                ->where('d.activated',true)->groupBy('dID')->get()->toArray();


//            $categoria = ['' => 'Seleccione la categoría'] + Categoria::lists('categoria', 'id')->all();
//            $escenar = $escenarios->pluck('escenario', 'escenario_id');

            return response($disciplinas);
        }
    }


}
