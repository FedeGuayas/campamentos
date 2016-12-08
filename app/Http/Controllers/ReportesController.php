<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Program;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReportesController extends Controller
{

    public function getExcel()
    {
//        $cursos=Calendar::with('horario','dia','program')->get();
//        $programs=Program::with('escenario','disciplina','modulo')->get();


        $cursos=Calendar::with('horario','dia','program')
            ->join('inscripcions as insc', 'insc.calendar_id','=','cal.id','as cal')
            ->join('facturas as fact','fact.id','=','insc.factura_id')
            ->get();
//        dd($cursos);

        return view('campamentos.reportes.reporte-excell',compact('cursos'));
    }
}
