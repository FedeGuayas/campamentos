<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Calendar;
use App\Escenario;
use App\Factura;
use App\Inscripcion;
use App\Persona;
use App\Program;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use DB;

use App\Http\Requests;

class ReportesController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es');
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
            ->whereNull('cart')//inscripciones internas sin las online
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
            ->whereNull('cart')
            ->orderBy('created_at')
            ->get();

        

        $arrayExp[] = ['Recibo','Apellidos_Alumno','Nombres_Alumno','Edad','Género','Apellidos_Representante','Nombres_Representante',
            'Modulo','Escenario','Disciplina','Dias','Horario','Comprobante','Valor','Descuento','Estado','Fecha_Insc','Forma_Pago','Usuario','Pto Cobro','Profesor'];

        foreach ($inscripciones as $insc) {

            if (is_null($insc->user->escenario_id)){
                $pto_cobro='';
            }else $pto_cobro=$insc->user->escenario->escenario;

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
                'pto_cobro' => $pto_cobro,
                'profe'=> $insc->calendar->profesor->getNameAttribute(),

            ];
        }

        Excel::create('Reporte_Campamentos - '.Carbon::now().'', function ($excel) use ($arrayExp) {

            $excel->sheet('Insc General', function ($sheet) use ($arrayExp) {

                $sheet->setBorder('A1:U1','thin', 'thin', 'thin', 'thin');
                $sheet->cells('A1:U1', function($cells){
                   $cells->setBackground('#F5F5F5');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');

                });

                $sheet->fromArray($arrayExp,null,'A1',false,false);

            });
        })->export('xlsx');

    }

    public function inscripcionPDF($id){

        $inscripcion=Inscripcion::with('factura','calendar','user','alumno')
            ->where('id',$id)
            ->withCount('factura')
            ->first();
        setlocale(LC_TIME, 'es');
        $fecha_actual =Carbon::now();
        $month = $fecha_actual->formatLocalized('%B');//mes en español
        $day = $fecha_actual->format('d');
        $year = $fecha_actual->format('Y');
        $date = $fecha_actual->format('Y-m-d');
       
      
                        
        if ($inscripcion->alumno_id==0){//adulto
            
            
            $pdf = PDF::loadView('campamentos.reportes.insc-adulto-pdf', compact('inscripcion','fecha_actual','month'));
//        return $pdf->download('ComprobantePago.pdf');//descarga el pdf
            return $pdf->stream('ComprobantePago');//imprime en pantalla
                
        }else {//menor
            
            $pdf = PDF::loadView('campamentos.reportes.insc-menor-pdf', compact('inscripcion','fecha_actual','month'));
//        return $pdf->download('ComprobantePago.pdf');//descarga el pdf
            return $pdf->stream('ComprobantePago');//imprime en pantalla
            
        }
    }


    public function cuadre(Request $request)
    {
        $escenarioSelect = ['' => 'Seleccione el escenario'] + Escenario::lists('escenario', 'id')->all();
//        $usuarioSelect = ['' => 'Seleccione el usuario'] + User::select(DB::raw('CONCAT(first_name, " ", last_name) AS nombre'), 'id')->lists('nombre', 'id')->all();

        if ($request) {
            $fecha = $request->get('fecha');
            $escenario = $request->get('escenario');
            $usuario = $request->get('usuario');


            $cuadre = DB::table('inscripcions as i')
                ->join('facturas as f', 'f.id', '=', 'i.factura_id')
                ->join('users as u', 'u.id', '=', 'i.user_id')
                ->select('f.total','i.factura_id', 'i.user_id as uid','i.created_at as fecha', 'u.first_name','u.last_name')
//                ->where('inscripcions.created_at', 'LIKE', '%' . $fecha . '%')
//                ->where('u.id','=', $usuario)
                ->groupBy('uid')
                ->get();
          

            $cuadreArray = [];
            foreach ($cuadre as $c) {

                $cuadreArray[] = [
                    'nombre' => $c->first_name.' '.$c->last_name,
                    'cantidad' => Inscripcion::where('user_id', $c->uid)->where('created_at', 'LIKE', '%' . $fecha . '%')->count(),
                    'valor' => Factura::where('id', $c->factura_id)->where('created_at', 'LIKE', '%' . $fecha . '%')->sum('total'),
                ];
            }
            


        }
        return view('campamentos.reportes.cuadre', compact('escenarioSelect', 'usuarioSelect', 'escenario', 'usuario', 'fecha', 'cuadreArray'));
    }


}
