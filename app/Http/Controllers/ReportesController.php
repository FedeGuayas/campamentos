<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Calendar;
use App\Inscripcion;
use App\Persona;
use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware(['role:supervisor|administrador']);
    }

    public function getExcel(Request $request)
    {

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
        

        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')
            ->whereBetween('created_at',[$start, $end])
//            ->where('created_at','>=',$start)
//            ->where('created_at','<=',$end)
            ->orderBy('created_at')
            ->get();



//        dd($inscripciones);

        return view('campamentos.reportes.reporte-excell',compact('inscripciones','start','end'));
    }
    
    public function exportExcel(Request $request){

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));


        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')
            ->whereBetween('created_at',[$start, $end])
//            ->where('created_at','>=',$start)
//            ->where('created_at','<=',$end)
            ->orderBy('created_at')
            ->get();

        

        $arrayExp[] = ['Recibo','Apellidos_Alumno','Nombres_Alumno','Edad','Género','Apellidos_Representante','Nombres_Representante',
            'Modulo','Escenario','Disciplina','Dias','Horario','Comprobante','Valor','Descuento','Estado','Fecha_Insc','Forma_Pago','Usuario'];

        foreach ($inscripciones as $insc) {
            

            if ($insc->alumno_id == 0) {
                $al_apell=$insc->factura->representante->persona->apellidos;
                $al_nomb=$insc->factura->representante->persona->nombres;
                $al_edad='Adulto';
                $genero=$insc->factura->representante->persona->genero;
            } else{
                $al_apell=$insc->alumno->persona->apellidos;
                $al_nomb=$insc->alumno->persona->nombres;

                $al=Alumno::where('id',$insc->alumno_id)->first();
                $fecha_nac=$al->persona->fecha_nac;
                $al_edad=$al->getEdad($fecha_nac);
                $genero=$insc->alumno->persona->genero;
            }

            $arrayExp[] = [
                'recibo' => $insc->id,
                'al_apell' => $al_apell,
                'al_nomb' => $al_nomb,
                'al_edad' => $al_edad,
                'al_genero' => $genero,
                'rep_apell' => $insc->factura->representante->persona->apellidos,
                'rep_nomb' => $insc->factura->representante->persona->nombres,
                'modulo' => $insc->calendar->program->modulo->modulo,
                'escenario' => $insc->calendar->program->escenario->escenario,
                'disciplina' => $insc->calendar->program->disciplina->disciplina,
                'dias' => $insc->calendar->dia->dia,
                'horario' => $insc->calendar->horario->start_time.'-'.$insc->calendar->horario->end_time,
                'comprobante' =>  $insc->factura->id,
                'valor' =>  $insc->factura->total,
                'descuento' =>  $insc->factura->descuento,
                'estado' =>  $insc->estado,
                'fecha_insc' =>  $insc->created_at,
                'fpago' => $insc->factura->pago->forma,
                'usuario' => $insc->user->getNameAttribute(),



//                'trabajador' => $task->user->getFullNameAttribute(),

            ];
        }

        Excel::create('Reporte_Campamentos - '.Carbon::now().'', function ($excel) use ($arrayExp) {

            $excel->sheet('Insc General', function ($sheet) use ($arrayExp) {

                $sheet->setBorder('A1:S1','thin', 'thin', 'thin', 'thin');
                $sheet->cells('A1:S1', function($cells){
                   $cells->setBackground('#F5F5F5');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');

                });

                $sheet->fromArray($arrayExp,null,'A1',false,false);

            });
        })->export('xlsx');

    }

    public function exportPDF(Request $requestquest, $id){
        return dd($id);
    }
}
