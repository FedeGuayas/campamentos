<?php

namespace App\Http\Controllers;

use App\Dia;
use App\Disciplina;
use App\Escenario;
use App\Horario;
use App\Modulo;
use Illuminate\Http\Request;
use DB;

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
        $programs=DB::table('disciplina_escenario as de')
            ->join('escenarios as e','e.id','=','de.escenario_id')
            ->join('disciplinas as d','d.id','=','de.disciplina_id')
            ->join('horarios as h','h.id','=','de.horario_id')
            ->join('dias as dia ','dia.id','=','de.dia_id')
            ->join('modulos as m','m.id','=','de.modulo_id')
            ->select('de.id','e.escenario','d.disciplina','h.start_time','h.end_time',
                'dia.dia','m.modulo','nivel','matricula','mensualidad','cupos','contador','de.activated')
            ->orderBy('de.id')->get();

        return view('campamentos.programs.index',compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $escenarios=[] + Escenario::where('activated','1')->lists('escenario', 'id')->all();
        $disciplinas=[] + Disciplina::lists('disciplina', 'id')->all();
        $dias=[] + Dia::lists('dia', 'id')->all();
        $horarios=[] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario'), 'id') ->lists('horario' , 'id')->all();
        $modulos=[] + Modulo::where('activated','1')->orderBy('modulo', 'desc')->lists('modulo', 'id')->all();
        
        return view('campamentos.programs.create',compact('escenarios','disciplinas','dias','horarios','modulos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramsStoreRequest $request)
    {
        $escenario_id=$request->get('escenario');
        $escenario=Escenario::findOrFail($escenario_id);
        $disciplina_id=$request->get('disciplina');
        $disciplina=Disciplina::findOrFail($disciplina_id);
        $horario_id=$request->get('hora');
//        $horario=Horario::findOrFail($horario_id);
        $dia_id=$request->get('dia');
//        $dia=Dia::findOrFail($dia_id);
        $modulo_id=$request->get('modulo');
//        $modulo=Modulo::findOrFail($modulo_id);
        $mensualidad=$request->get('mensualidad');
        $matricula=$request->get('matricula');
        $cupos=$request->get('cupos');
        $nivel=$request->get('nivel');
        $activated=true;
        $contador=0;


        $escenario->disciplinas()->attach($disciplina,[
            'horario_id' => $horario_id,
            'dia_id' => $dia_id,
            'modulo_id' => $modulo_id,
            'mensualidad' => $mensualidad,
            'matricula' => $matricula,
            'cupos' => $cupos,
            'nivel' => $nivel,
            'activated' => $activated,
            'contador' => $contador,
        ]);

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
        //$user->roles()->updateExistingPivot($roleId, $attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $user->roles()->detach([1, 2, 3]);
    }

    public function disable(Request $request,$id)
    {
        $program=DB::table('disciplina_escenario as de')
            ->where('de.id',$id);

//        $escenario_id=$program->escenario_id;
//        $escenario=Escenario::findOrFail($escenario_id);
//        $disciplina_id=$request->get('disciplina_id');
//        $disciplina=Disciplina::findOrFail($disciplina_id);
//        $activated=false;
        dd($program);
//        $user->roles()->syncWithoutDetaching([1, 2, 3]);
//        $user->roles()->updateExistingPivot($roleId, $attributes);

//        $user->roles()->updateExistingPivot($roleId, $attributes);
//        $program->update();
        return back();
    }

    public function enable($id)
    {
        $program=DB::table('disciplina_escenario as de')
            ->where('de.id',$id);
        $program->activated=true;
        $program->update();
        return back();
    }

}
