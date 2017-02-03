<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Calendar;
use App\Disciplina;
use App\Escenario;
use App\Factura;
use App\Horario;
use App\Inscripcion;
use App\Modulo;
use App\Persona;
use App\Profesor;
use App\Program;
use App\Representante;
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


    /**
     * Vista para Reporte general
     * @param Request $request
     * @return mixed
     */
    public function getExcel(Request $request)
    {
        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        $start=new Carbon($start);
        $start=$start->toDateString();
        $end=new Carbon($end);
        $end=$end->toDateString();

        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')
            ->whereBetween('created_at',[$start, $end])
//            ->where('created_at','>=',$start)
//            ->where('created_at','<=',$end)
            ->whereNull('cart')//inscripciones internas sin las online
            ->orderBy('created_at')
            ->paginate(10);

        return view('campamentos.reportes.reporte-excell',compact('inscripciones','start','end'));
    }

    /**
     * Exportar Reporte General a excel
     * @param Request $request
     */
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

        $arrayExp[] = ['Recibo','Apellidos_Alumno','Nombres_Alumno','Edad','Género','Representante','Cedeula Rep','Telefono','Correo','Direccion',
            'Modulo','Escenario','Disciplina','Dias','Horario','Comprobante','Valor','Descuento','Estado','Fecha_Insc','Forma_Pago','Usuario','Pto Cobro','Profesor'];

        foreach ($inscripciones as $insc) {

            if (is_null($insc->user->escenario_id)){
                $pto_cobro='';
            }else $pto_cobro=$insc->user->escenario->escenario;

            if ($insc->alumno_id == 0) {
                $al_apell=$insc->factura->representante->persona->apellidos;
                $al_nomb=$insc->factura->representante->persona->nombres;

                $al=Representante::where('id',$insc->factura->representante_id)->first();
                $fecha_nac=$insc->factura->representante->persona->fecha_nac;
                $al_edad=$al->getEdad($fecha_nac);
                $genero=$insc->factura->representante->persona->genero;
            } else{
                $al_apell=$insc->alumno->persona->apellidos;
                $al_nomb=$insc->alumno->persona->nombres;

                $al=Alumno::where('id',$insc->alumno_id)->first();
                $fecha_nac=$al->persona->fecha_nac;
                $al_edad=$al->getEdad($fecha_nac);
                $genero=$insc->alumno->persona->genero;
            }

            $cont_comp=Inscripcion::where('factura_id',$insc->factura_id)->count();

            $arrayExp[] = [
                'recibo' => $insc->id,
                'al_apell' => $al_apell,
                'al_nomb' => $al_nomb,
                'al_edad' => $al_edad,
                'al_genero' => $genero,
//                'rep_apell' => $insc->factura->representante->persona->apellidos,
//                'rep_nomb' => $insc->factura->representante->persona->nombres,
                'representante' => $insc->factura->representante->persona->getNombreAttribute(),
                'ced_representante'=>$insc->factura->representante->persona->num_doc,
                'tel_representante'=>$insc->factura->representante->persona->telefono,
                'email_representante'=>$insc->factura->representante->persona->email,
                'direccion_representante'=>$insc->factura->representante->persona->direccion,
                'modulo' => $insc->calendar->program->modulo->modulo,
                'escenario' => $insc->calendar->program->escenario->escenario,
                'disciplina' => $insc->calendar->program->disciplina->disciplina,
                'dias' => $insc->calendar->dia->dia,
                'horario' => $insc->calendar->horario->start_time.'-'.$insc->calendar->horario->end_time,
                'comprobante' =>  $insc->factura->id,
                'valor' =>  round(($insc->factura->total)/$cont_comp,3),
                'descuento' =>  $insc->factura->descuento,
                'estado' =>  $insc->estado,
                'fecha_insc' =>  $insc->created_at,
                'fpago' => $insc->factura->pago->forma,
                'usuario' => $insc->user->getNameAttribute(),
                'pto_cobro' => $pto_cobro,
                'profe'=> $insc->calendar->profesor->getNameAttribute(),

            ];
        }

        Excel::create('Reporte_General_Campamentos- '.Carbon::now().'', function ($excel) use ($arrayExp) {

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

    //comprobantes de inscripciones
    public function inscripcionPDF($id){

        $inscripcion=Inscripcion::with('factura','calendar','user','alumno')
            ->where('id',$id)
            ->withCount('factura')
            ->first();
        setlocale(LC_TIME, 'es');
        $fecha_actual = Carbon::now();
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
            $fecha=new Carbon($fecha);
            $fecha=$fecha->toDateString();
            $escenario = $request->get('escenario');
            $usuario = $request->get('usuario');

            $cuadre = Factura::
            join('inscripcions as i', 'i.factura_id', '=', 'facturas.id')
                ->join('users as u', 'u.id', '=', 'i.user_id')
                ->select('total','factura_id', 'i.user_id as uid', 'u.first_name','u.last_name','u.escenario_id', 'i.created_at','i.id')
                ->where('facturas.created_at', 'like', '%' . $fecha . '%')
                ->where('u.escenario_id', $escenario)
                ->groupBy('factura_id')
                ->get();

            $group=[];
            //crear array agrupando por el nombre de usuario  y agregar los valores de las facturas
            foreach ($cuadre as $c) {
                $user= $c->first_name.' '.$c->last_name;
                $i=$c->total;
                $group[$user][] = [
                    "Nombre"=>$user,
                    "factura"=>$i];
            }


            //sumar columnas para total por usuario y Total general
            $cuadreArray = [];
            $precioFinal = 0;
            foreach($group as $nombre=> $fact){
                $precioGrupo = 0;
                foreach($group[$nombre] as $r){
                    //acumulados
                    $precioGrupo += $r['factura'];
                    //totales Finales
                    $precioFinal += $r['factura'];
                }
                $cuadreArray []= [
                    "factura"=>$precioGrupo,
                    "nombre"=>$nombre,
                ];
//                $group[$nombre]['acumulados'] = ["factura"=>$precioGrupo ];
            }
//            $group['TotalesFinales'] = array("factura"=>$precioFinal);
            $total=[
                "total"=>$precioFinal
            ];

        }
        return view('campamentos.reportes.cuadre', compact('escenarioSelect', 'usuarioSelect', 'escenario', 'usuario',
            'fecha', 'cuadreArray','total'));
    }


    /**
     * Vista para generar  Reporte Personalizado
     * @param Request $request
     * @return mixed
     */
    public function getPersonal(Request $request)
    {
//        $start = trim($request->get('start'));
//        $end = trim($request->get('end'));
//
//        $start=new Carbon($start);
//        $start=$start->toDateString();
//        $end=new Carbon($end);
//        $end=$end->toDateString();

        $escenarioSelect = ['' => 'Seleccione el escenario'] + Escenario::lists('escenario', 'id')->all();
        $escenario = $request->get('escenario');
        $moduloSelect=['' => 'Seleccione el modulo *'] + Modulo::lists('modulo', 'id')->all();
        $modulo = $request->get('modulo');
        $disciplinaSelect=['' => 'Seleccione la disciplina'] + Disciplina::lists('disciplina', 'id')->all();
        $disciplina = $request->get('disciplina');
        $horarioSelect=['' => 'Seleccione horario'] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario' ), 'id')->orderBy('start_time')->lists('horario','id')->all();
        $horario = $request->get('horario');
        $entrenadorSelect=['' => 'Seleccione entrenador'] + Profesor::select(DB::raw('CONCAT(nombres, " ", apellidos) AS entrenador'), 'id')->orderBy('nombres')-> lists('entrenador', 'id')->all();
        $entrenador = $request->get('entrenador');
        $sexo = $request->get('sexo');

        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')
            ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
            ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
            ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
            ->join('profesors', 'profesors.id', '=', 'calendars.profesor_id')
//            ->whereBetween('inscripcions.created_at',[$start, $end])
//            ->where('inscripcions.created_at','like','%'.$start.'%')
//            ->where('inscripcions.created_at','like','%'.$end.'%')
            ->whereNull('cart')//inscripciones internas sin las online
            ->where('modulos.id',$modulo)
            ->where('escenarios.id','like','%'.$escenario.'%')
            ->where('disciplinas.id','like','%'.$disciplina.'%')
            ->where('horarios.id','like','%'.$horario.'%')
            ->where('profesors.id','like','%'.$entrenador.'%')
//            ->where('sexo','like','%'.$sexo.'%')
            ->orderBy('inscripcions.created_at')
            ->paginate(10);

        return view('campamentos.reportes.reporte-personalizado',compact('inscripciones','escenarioSelect',
            'escenario','moduloSelect','modulo','disciplinaSelect','disciplina','horarioSelect','horario','entrenadorSelect',
            'entrenador','sexo'));
    }


    public function exportPersonal(Request $request){

//        $start = trim($request->get('start'));
//        $end = trim($request->get('end'));
//
//        $start=new Carbon($start);
//        $start=$start->toDateString();
//        $end=new Carbon($end);
//        $end=$end->toDateString();

        $escenarioSelect = ['' => 'Seleccione el escenario'] + Escenario::lists('escenario', 'id')->all();
        $escenario = $request->get('escenario');
        $moduloSelect=['' => 'Seleccione el modulo'] + Modulo::lists('modulo', 'id')->all();
        $modulo = $request->get('modulo');
        $disciplinaSelect=['' => 'Seleccione la disciplina'] + Disciplina::lists('disciplina', 'id')->all();
        $disciplina = $request->get('disciplina');
        $horarioSelect=['' => 'Seleccione horario'] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario' ), 'id')->orderBy('start_time')->lists('horario','id')->all();
        $horario = $request->get('horario');
        $entrenadorSelect=['' => 'Seleccione entrenador'] + Profesor::select(DB::raw('CONCAT(nombres, " ", apellidos) AS entrenador'), 'id')->orderBy('nombres')-> lists('entrenador', 'id')->all();
        $entrenador = $request->get('entrenador');
        $sexo = $request->get('sexo');

        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')
            ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
            ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
            ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
            ->join('profesors', 'profesors.id', '=', 'calendars.profesor_id')
//            ->whereBetween('inscripcions.created_at',[$start, $end])
//            ->where('inscripcions.created_at','like','%'.$start.'%')
//            ->where('inscripcions.created_at','like','%'.$end.'%')
            ->whereNull('cart')//inscripciones internas sin las online
            ->where('modulos.id',$modulo)
            ->where('escenarios.id','like','%'.$escenario.'%')
            ->where('disciplinas.id','like','%'.$disciplina.'%')
            ->where('horarios.id','like','%'.$horario.'%')
            ->where('profesors.id','like','%'.$entrenador.'%')
//            ->where('sexo','like','%'.$sexo.'%')
            ->orderBy('inscripcions.created_at')
            ->get();

        $arrayExp[] = ['Recibo','Apellidos_Alumno','Nombres_Alumno','Edad','Género','Representante','Cedeula Rep','Telefono','Correo','Direccion',
            'Modulo','Escenario','Disciplina','Dias','Horario','Comprobante','Valor','Descuento','Estado','Fecha_Insc','Forma_Pago','Usuario','Pto Cobro','Profesor'];

        foreach ($inscripciones as $insc) {

            if (is_null($insc->user->escenario_id)){
                $pto_cobro='';
            }else $pto_cobro=$insc->user->escenario->escenario;

            if ($insc->alumno_id == 0) {
                $al_apell=$insc->factura->representante->persona->apellidos;
                $al_nomb=$insc->factura->representante->persona->nombres;

                $al=Representante::where('id',$insc->factura->representante_id)->first();
                $fecha_nac=$insc->factura->representante->persona->fecha_nac;
                $al_edad=$al->getEdad($fecha_nac);
                $genero=$insc->factura->representante->persona->genero;
            } else{
                $al_apell=$insc->alumno->persona->apellidos;
                $al_nomb=$insc->alumno->persona->nombres;

                $al=Alumno::where('id',$insc->alumno_id)->first();
                $fecha_nac=$al->persona->fecha_nac;
                $al_edad=$al->getEdad($fecha_nac);
                $genero=$insc->alumno->persona->genero;
            }

            $cont_comp=Inscripcion::where('factura_id',$insc->factura_id)->count();

            $arrayExp[] = [
                'recibo' => $insc->id,
                'al_apell' => $al_apell,
                'al_nomb' => $al_nomb,
                'al_edad' => $al_edad,
                'al_genero' => $genero,
                'representante' => $insc->factura->representante->persona->getNombreAttribute(),
                'ced_representante'=>$insc->factura->representante->persona->num_doc,
                'tel_representante'=>$insc->factura->representante->persona->telefono,
                'email_representante'=>$insc->factura->representante->persona->email,
                'direccion_representante'=>$insc->factura->representante->persona->direccion,
                'modulo' => $insc->calendar->program->modulo->modulo,
                'escenario' => $insc->calendar->program->escenario->escenario,
                'disciplina' => $insc->calendar->program->disciplina->disciplina,
                'dias' => $insc->calendar->dia->dia,
                'horario' => $insc->calendar->horario->start_time.'-'.$insc->calendar->horario->end_time,
                'comprobante' =>  $insc->factura->id,
                'valor' =>  round(($insc->factura->total)/$cont_comp,3),
                'descuento' =>  $insc->factura->descuento,
                'estado' =>  $insc->estado,
                'fecha_insc' =>  $insc->factura->created_at,
                'fpago' => $insc->factura->pago->forma,
                'usuario' => $insc->user->getNameAttribute(),
                'pto_cobro' => $pto_cobro,
                'profe'=> $insc->calendar->profesor->getNameAttribute(),

            ];
        }


        Excel::create('Reporte_Personalizado_Campamentos - '.Carbon::now().'', function ($excel) use ($arrayExp) {

            $excel->sheet('Insc General', function ($sheet) use ($arrayExp) {

                $sheet->setBorder('A1:X1','thin', 'thin', 'thin', 'thin');
                $sheet->cells('A1:X1', function($cells){
                    $cells->setBackground('#F5F5F5');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');

                });

                $sheet->fromArray($arrayExp,null,'A1',false,false);

            });
        })->export('xlsx');
    }




}
