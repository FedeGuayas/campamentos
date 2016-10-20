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
use App\Http\Requests;
use App\Http\Requests\CalendarStoreRequest;


class CalendarsController extends Controller
{
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
            ->select('e.escenario','dis.disciplina','m.modulo','d.dia','h.start_time','h.end_time','cupos','contador','mensualidad','c.id')
            ->where('p.activated',true)

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
       
        $horarios=[] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario'), 'id')->lists('horario','id')->all();
        $dias=[]+ Dia::lists('dia','id')->all();
        
        return view('campamentos.calendars.create',compact('program','horarios','dias','escenario','disciplina','modulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarStoreRequest $request)
    {
        $calendar=new Calendar;
        $calendar->program_id=$request->get('program_id');
        $calendar->dia_id=$request->get('dia_id');
        $calendar->horario_id=$request->get('horario_id');
        $calendar->cupos=$request->get('cupos');
        $calendar->mensualidad=$request->get('mensualidad');
//        $calendar->nivel=$request->get('nivel');
        $calendar->save();
        
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

        return view('campamentos.calendars.edit',compact('calendar','horarios','dias','escenario','disciplina','modulo'));
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
        $calendar=Calendar::findOrFail($id);
//        $calendar->program_id=$request->get('program_id');
//        $calendar->dia_id=$request->get('dia_id');
//        $calendar->horario_id=$request->get('horario_id');
//        $calendar->cupos=$request->get('cupos');
//        $calendar->mensualidad=$request->get('mensualidad');
//        $calendar->nivel=$request->get('nivel');

        $calendar->update($request->all());
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
        //
    }
}
