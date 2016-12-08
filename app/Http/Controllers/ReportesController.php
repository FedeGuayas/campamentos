<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Inscripcion;
use App\Program;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Http\Requests;

class ReportesController extends Controller
{

    public function getExcel()
    {
//        $cursos=Calendar::with('horario','dia','program')->get();
//        $programs=Program::with('escenario','disciplina','modulo')->get();


        $cursos=Calendar::with('horario','dia','program','inscripcions')
            ->join('inscripcions as insc', 'insc.calendar_id','=','cal.id','as cal')
            ->join('facturas as fact','fact.id','=','insc.factura_id')
            ->get();
        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')

            ->get();

//        $inscripciones->each(function ($inscripciones){
//            $inscripciones->factura;
//            $inscripciones->calendar->program;
//            $inscripciones->user;
//            $inscripciones->alumno;
//        });

//        dd($inscripciones);

        return view('campamentos.reportes.reporte-excell',compact('inscripciones'));
    }

    public function exportPDF(Request $requestquest, $id){
        return dd($id);
    }
}
