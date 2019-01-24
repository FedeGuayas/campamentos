<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 300);

use App\Alumno;
use App\Calendar;
use App\Dia;
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
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Session;


use App\Http\Requests;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware(['role:supervisor|administrador']);
    }


    /**
     * Vista para Generar Reporte por Periodo de Inscripción
     * @param Request $request
     * @return mixed
     */
    public function getExcel(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $start = new Carbon($start);
        $start = $start->toDateString();
        $end = new Carbon($end);
        $end = $end->toDateString();

        $inscripciones = Inscripcion::
        with('factura', 'calendar', 'user', 'alumno', 'escenario')
            ->whereHas('factura', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end]);
            })
            ->where('inscripcions.estado', 'Pagada')
            ->whereNull('cart')//inscripciones internas sin las online
            ->paginate(10);

        return view('campamentos.reportes.reporte-excell', compact('inscripciones', 'start', 'end'));
    }

    /**
     * Exportar Generar Reporte por Periodo de Inscripción
     * @param Request $request
     */
    public function exportExcel(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $start = new Carbon($start);
        $start = $start->toDateString();
        $end = new Carbon($end);
        $end = $end->toDateString();

        $inscripciones = Inscripcion::
        with('factura', 'calendar', 'user', 'alumno', 'escenario')
            ->whereHas('factura', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end]);
            })
            ->where('inscripcions.estado', 'Pagada')
            ->whereNull('cart');


        $arrayExp[] = ['Recibo', 'Apellidos_Alumno', 'Nombres_Alumno', 'Edad', 'Género', 'Representante', 'Cedula Rep', 'Telefono', 'Correo', 'Direccion',
            'Modulo', 'Escenario', 'Disciplina', 'Dias', 'Horario', 'Comprobante', 'Valor', 'Descuento', 'Estado', 'Fecha_Cobro', 'Forma_Pago', 'Usuario', 'Pto Cobro', 'Profesor'];

        $count = $inscripciones->count();
        $off_ex = 100;
        for ($j = 0; $j < $count / $off_ex; $j++) {

            $inscripcioness = $inscripciones->skip($j * $off_ex)->take($off_ex)->get();

            foreach ($inscripcioness as $insc) {

                if (is_null($insc->escenario_id) || $insc->escenario_id == '0') {//online
                    $pto_cobro = 'N/A';
                } else $pto_cobro = $insc->escenario->escenario;

                if ($insc->alumno_id == 0) {
                    $al_apell = $insc->factura->representante->persona->apellidos;
                    $al_nomb = $insc->factura->representante->persona->nombres;

                    $al = Representante::where('id', $insc->factura->representante_id)->first();
                    $fecha_nac = $insc->factura->representante->persona->fecha_nac;
                    $al_edad = $al->getEdad($fecha_nac);
                    $genero = $insc->factura->representante->persona->genero;
                } else {
                    $al_apell = $insc->alumno->persona->apellidos;
                    $al_nomb = $insc->alumno->persona->nombres;

                    $al = Alumno::where('id', $insc->alumno_id)->first();
                    $fecha_nac = $al->persona->fecha_nac;
                    $al_edad = $al->getEdad($fecha_nac);
                    $genero = $insc->alumno->persona->genero;
                }

                if (is_null($insc->calendar->profesor) || $insc->calendar->profesor == '') {//profesor eliminado
                    $profesor = 'N/A';
                } else $profesor =  $insc->calendar->profesor->getNameAttribute();

                $cont_comp = Inscripcion::where('factura_id', $insc->factura_id)->count();

                $arrayExp[] = [
                    'recibo' => $insc->id,
                    'al_apell' => $al_apell,
                    'al_nomb' => $al_nomb,
                    'al_edad' => $al_edad,
                    'al_genero' => $genero,
                    'representante' => $insc->factura->representante->persona->getNombreAttribute(),
                    'ced_representante' => $insc->factura->representante->persona->num_doc,
                    'tel_representante' => $insc->factura->representante->persona->telefono,
                    'email_representante' => $insc->factura->representante->persona->email,
                    'direccion_representante' => $insc->factura->representante->persona->direccion,
                    'modulo' => $insc->calendar->program->modulo->modulo,
                    'escenario' => $insc->calendar->program->escenario->escenario,
                    'disciplina' => $insc->calendar->program->disciplina->disciplina,
                    'dias' => $insc->calendar->dia->dia,
                    'horario' => $insc->calendar->horario->start_time . '-' . $insc->calendar->horario->end_time,
                    'comprobante' => $insc->factura->id,
                    'valor' => round(($insc->factura->total) / $cont_comp, 3),
                    'descuento' => $insc->factura->descuento,
                    'estado' => $insc->estado,
                    'fecha_cob' => $insc->factura->created_at,
                    'fpago' => $insc->factura->pago->forma,
                    'usuario' => $insc->user->getNameAttribute(),
                    'pto_cobro' => $pto_cobro,
                    'profe' => $profesor,
                ];
            }
        }

        set_time_limit(0);
        ini_set('memory_limit', '1G');

        Excel::create('Reporte_General_Campamentos- ' . Carbon::now() . '', function ($excel) use ($arrayExp) {

            $excel->sheet('Insc General', function ($sheet) use ($arrayExp) {

                $sheet->setBorder('A1:U1', 'thin', 'thin', 'thin', 'thin');
                $sheet->cells('A1:U1', function ($cells) {
                    $cells->setBackground('#F5F5F5');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');

                });

                $sheet->fromArray($arrayExp, null, 'A1', false, false);

            });
        })->export('xlsx');

    }

    /**
     * Comprovantes de inscripcion en pdf
     * @param $id
     * @return mixed
     */
    public function inscripcionPDF($id)
    {

        $inscripcion = Inscripcion::with('factura', 'calendar', 'user', 'alumno')
            ->where('id', $id)
            ->withCount('factura')
            ->first();

        setlocale(LC_TIME, 'es');
        $fecha_actual = Carbon::now();
        $month = $fecha_actual->formatLocalized('%B');//mes en español
        $day = $fecha_actual->format('d');
        $year = $fecha_actual->format('Y');
        $date = $fecha_actual->format('Y-m-d');

        $fecha_evento_inicio=new Carbon($inscripcion->calendar->program->modulo->inicio);
        $fecha_evento_inicio=$fecha_evento_inicio->formatLocalized('%d %B %Y');
        $fecha_evento_fin=new Carbon($inscripcion->calendar->program->modulo->fin);
        $fecha_evento_fin=$fecha_evento_fin->formatLocalized('%d %B %Y');

        $fecha_evento=strtoupper($fecha_evento_inicio);

        set_time_limit(0);
        ini_set('memory_limit', '1G');

        if ($inscripcion->alumno_id == 0) {//adulto

            if ((stristr($inscripcion->calendar->program->disciplina->disciplina, 'II FESTIVAL DE NATACION') ) ) {
                $pdf = PDF::loadView('campamentos.reportes.insc-festival2-pdf', compact('inscripcion', 'fecha_actual', 'month','fecha_evento'));
                return $pdf->stream('ComprobanteFestival ' . $inscripcion->id . '.pdf');//imprime en pantalla
            }

            $pdf = PDF::loadView('campamentos.reportes.insc-adulto-pdf', compact('inscripcion', 'fecha_actual', 'month'));
//        return $pdf->download('ComprobantePago.pdf');//descarga el pdf

            return $pdf->stream('ComprobantePagoAdulto ' . $inscripcion->id . '.pdf');//imprime en pantalla

        } else {//menor

            if ((stristr($inscripcion->calendar->program->disciplina->disciplina, 'II FESTIVAL DE NATACION') ) ) {
                $pdf = PDF::loadView('campamentos.reportes.insc-festival2-pdf', compact('inscripcion', 'fecha_actual', 'month','fecha_evento'));
                return $pdf->stream('ComprobanteFestival ' . $inscripcion->id . '.pdf');//imprime en pantalla
            }

            $pdf = PDF::loadView('campamentos.reportes.insc-menor-pdf', compact('inscripcion', 'fecha_actual', 'month'));
//        return $pdf->download('ComprobantePago.pdf');//descarga el pdf
            return $pdf->stream('ComprobantePagoMenor ' . $inscripcion->id . '.pdf');//imprime en pantalla

        }
    }

    /**
     * Mostrar el cuadre diario de las ventas de los usuarios
     * @param Request $request
     * @return mixed
     */
    public function cuadre(Request $request)
    {
        $escenarioSelect = ['' => 'Seleccione el escenario'] + Escenario::lists('escenario', 'id')->all();

        if ($request) {
            $fecha = $request->get('fecha');
            $fecha = new Carbon($fecha);
            $fecha = $fecha->toDateString();
            $escenario = $request->get('escenario');
            $usuario = $request->get('usuario');

            $cuadre = Factura::
            join('inscripcions as i', 'i.factura_id', '=', 'facturas.id')
                ->join('users as u', 'u.id', '=', 'i.user_id')
                ->join('pagos as p', 'p.id', '=', 'facturas.pago_id')
                ->select('total', 'factura_id', 'i.user_id as uid', 'u.first_name', 'u.last_name', 'u.escenario_id', 'i.created_at', 'i.id', 'i.estado', 'p.id as pagoID', 'p.forma')
                ->where('i.estado', '=', 'Pagada')
                ->where('facturas.created_at', 'like', '%' . $fecha . '%')
                ->where('i.escenario_id', 'like', '%' . $escenario . '%')
                ->groupBy('factura_id')//agrupo por facturas de la tabla inscripciones xk hay varias insccripciones con una misma factura
                ->get();

            $group = [];

            //crear array agrupando por el nombre de usuario  y agregar los valores de las facturas
            foreach ($cuadre as $c) {
                $user = $c->first_name . ' ' . $c->last_name;
                $i = $c->total;
                $forma = $c->forma;
                $group[$user][] = [
                    "Nombre" => $user,
                    "precio" => $i,
                    "fpago" => $forma,
                ];
            }
            //sumar columnas para total por usuario y Total general
            $cuadreArray = [];
            $valorFinal = 0;
            $totalContado = 0;
            $totalTarjeta = 0;
            $totalWestern = 0;
            foreach ($group as $nombre => $fp) {
                $valorUsuario = 0;
                $valorContado = 0;
                $valorTarjeta = 0;
                $valorWestern = 0;
                foreach ($group[$nombre] as $key => $value) { // agrupar los valores de las facturas por usuario
                    //acumulados
                    if (stristr($value['fpago'], 'contado')) {
                        $valorContado += $value['precio']; //acumulado de contado para el usuario
                        $totalContado += $value['precio']; //acumulado total de contado
                    }
                    if (stristr($value['fpago'], 'tarjeta')) {
                        $valorTarjeta += $value['precio'];
                        $totalTarjeta += $value['precio'];
                    }
                    if (stristr($value['fpago'], 'western')) {
                        $valorWestern += $value['precio'];
                        $totalWestern += $value['precio'];
                    }
                    $valorUsuario += $value['precio']; //acumulado para el usuario actual
                    $valorFinal += $value['precio']; //acumulado total
                }
                $cuadreArray [] = [
                    "valor" => $valorUsuario,
                    "usuario" => $nombre,
                    "contado" => $valorContado,
                    "tarjeta" => $valorTarjeta,
                    "western" => $valorWestern
                ];
            }

            $total = [
                "totalWestern" => $totalWestern,
                "totalContado" => $totalContado,
                "totalTarjeta" => $totalTarjeta,
                "totalGeneral" => $valorFinal,
            ];
        }

        return view('campamentos.reportes.cuadre', compact('escenarioSelect', 'usuarioSelect', 'escenario', 'usuario',
            'fecha', 'cuadreArray', 'total', 'cuadre'));
    }

    /**
     * Vista para generar  Reporte Personalizado
     * @param Request $request
     * @return mixed
     */
    public function getPersonal(Request $request)
    {
        $escenarioSelect = ['' => 'Seleccione el escenario'] + Escenario::lists('escenario', 'id')->all();
        $escenario = $request->get('escenario');
        $moduloSelect = ['' => 'Seleccione el modulo*'] + Modulo::lists('modulo', 'id')->all();
//        modulos_coll = Modulo::where('activated', true);
//        $modulos = $modulos_coll->pluck('modulo', 'id');
        $modulo = $request->get('modulo');
        $disciplinaSelect = ['' => 'Seleccione la disciplina'] + Disciplina::lists('disciplina', 'id')->all();
        $disciplina = $request->get('disciplina');
        $horarioSelect = ['' => 'Seleccione horario'] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario'), 'id')->orderBy('start_time')->lists('horario', 'id')->all();
        $horario = $request->get('horario');
        $diaSelect = ['' => 'Seleccione dia'] + Dia::orderBy('dia')->lists('dia', 'id')->all();
        $dia = $request->get('dia');
        $entrenadorSelect = ['' => 'Seleccione entrenador'] + Profesor::select(DB::raw('CONCAT(nombres, " ", apellidos) AS entrenador'), 'id')->orderBy('nombres')->lists('entrenador', 'id')->all();
        $entrenador = $request->get('entrenador');
        $sexo = $request->get('sexo');

        $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
            ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
            ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
            ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
            ->join('profesors', 'profesors.id', '=', 'calendars.profesor_id')
            ->join('dias', 'dias.id', '=', 'calendars.dia_id')
//            ->whereBetween('inscripcions.created_at',[$start, $end])
//            ->where('inscripcions.created_at','like','%'.$start.'%')
//            ->where('inscripcions.created_at','like','%'.$end.'%')
            ->whereNull('cart')//inscripciones internas sin las online
            ->where('estado', '=', 'Pagada')
            ->where('modulos.id', $modulo)
            ->where('escenarios.id', 'like', '%' . $escenario . '%')
            ->where('disciplinas.id', 'like', '%' . $disciplina . '%')
            ->where('horarios.id', 'like', '%' . $horario . '%')
            ->where('profesors.id', 'like', '%' . $entrenador . '%')
            ->where('dias.id', 'like', '%' . $dia . '%')
//            ->where('sexo','like','%'.$sexo.'%')
            ->orderBy('inscripcions.created_at')
            ->paginate(10);

        return view('campamentos.reportes.reporte-personalizado', compact('inscripciones', 'escenarioSelect',
            'escenario', 'moduloSelect', 'modulo', 'disciplinaSelect', 'disciplina', 'horarioSelect', 'horario', 'entrenadorSelect', 'entrenador', 'sexo', 'diaSelect', 'dia'));
    }

    /**
     * Reporte en excel filtrado con modulo obligatorio
     * @param Request $request
     */
    public function exportPersonal(Request $request)
    {
        $escenario = $request->get('escenario');
        $modulo = $request->get('modulo');
        $disciplina = $request->get('disciplina');
        $horario = $request->get('horario');
        $dia = $request->get('dia');
        $entrenador = $request->get('entrenador');
        $sexo = $request->get('sexo');

        $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
            ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
            ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
            ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
            ->join('profesors', 'profesors.id', '=', 'calendars.profesor_id')
            ->join('dias', 'dias.id', '=', 'calendars.dia_id')
            ->select('inscripcions.*')
//            ->whereBetween('inscripcions.created_at',[$start, $end])
//            ->where('inscripcions.created_at','like','%'.$start.'%')
//            ->where('inscripcions.created_at','like','%'.$end.'%')
            ->whereNull('cart')//inscripciones internas sin las online
            ->where('estado', '=', 'Pagada')
            ->where('modulos.id', $modulo)
            ->where('escenarios.id', 'like', '%' . $escenario . '%')
            ->where('disciplinas.id', 'like', '%' . $disciplina . '%')
            ->where('horarios.id', 'like', '%' . $horario . '%')
            ->where('profesors.id', 'like', '%' . $entrenador . '%')
            ->where('dias.id', 'like', '%' . $dia . '%')
//            ->where('sexo','like','%'.$sexo.'%')
            ->orderBy('inscripcions.created_at')
            ->get();

        $arrayExp[] = ['No. Reg.', 'Apellidos_Alumno', 'Nombres_Alumno', 'Cedula Alum.', 'Edad', 'Género', 'Representante', 'Cedula Rep', 'Telefono', 'Correo', 'Direccion', 'Modulo', 'Escenario', 'Disciplina', 'Nivel', 'Dias', 'Horario', 'Comprobante', 'Valor', 'Descuento', 'Estado', 'Fecha_Insc', 'Forma_Pago', 'Usuario', 'Pto Cobro', 'Profesor'];

        foreach ($inscripciones->chunk(500) as $chunkInsc) {
            foreach ($chunkInsc as $insc) {

                if (is_null($insc->escenario_id) || $insc->escenario_id == '0') {//online
                    $pto_cobro = 'N/A';
                } else $pto_cobro = $insc->escenario->escenario;

                if ($insc->alumno_id == 0) {
                    $al_apell = $insc->factura->representante->persona->apellidos;
                    $al_nomb = $insc->factura->representante->persona->nombres;

                    $al = Representante::where('id', $insc->factura->representante_id)->first();
                    $fecha_nac = $insc->factura->representante->persona->fecha_nac;
                    $al_edad = $al->getEdad($fecha_nac);
                    $genero = $insc->factura->representante->persona->genero;
                    $al_ced = $insc->factura->representante->persona->num_doc;
                } else {
                    $al_apell = $insc->alumno->persona->apellidos;
                    $al_nomb = $insc->alumno->persona->nombres;

                    $al = Alumno::where('id', $insc->alumno_id)->first();
                    $fecha_nac = $al->persona->fecha_nac;
                    $al_edad = $al->getEdad($fecha_nac);
                    $genero = $insc->alumno->persona->genero;
                    $al_ced = $insc->alumno->persona->num_doc;
                }

                $cont_comp = Inscripcion::where('factura_id', $insc->factura_id)->count();

                $arrayExp[] = [
                    'reg' => $insc->id,
                    'al_apell' => $al_apell,
                    'al_nomb' => $al_nomb,
                    'al_ced' => $al_ced,
                    'al_edad' => $al_edad,
                    'al_genero' => $genero,
                    'representante' => $insc->factura->representante->persona->getNombreAttribute(),
                    'ced_representante' => $insc->factura->representante->persona->num_doc,
                    'tel_representante' => $insc->factura->representante->persona->telefono,
                    'email_representante' => $insc->factura->representante->persona->email,
                    'direccion_representante' => $insc->factura->representante->persona->direccion,
                    'modulo' => $insc->calendar->program->modulo->modulo,
                    'escenario' => $insc->calendar->program->escenario->escenario,
                    'disciplina' => $insc->calendar->program->disciplina->disciplina,
                    'nivel' => $insc->calendar->nivel,
                    'dias' => $insc->calendar->dia->dia,
                    'horario' => $insc->calendar->horario->start_time . '-' . $insc->calendar->horario->end_time,
                    'comprobante' => $insc->factura->id,
                    'valor' => round(($insc->factura->total) / $cont_comp, 3),
                    'descuento' => $insc->factura->descuento,
                    'estado' => $insc->estado,
                    'fecha_insc' => $insc->factura->created_at->toDateString(),
                    'fpago' => $insc->factura->pago->forma,
                    'usuario' => $insc->user->getNameAttribute(),
                    'pto_cobro' => $pto_cobro,
                    'profe' => $insc->calendar->profesor->getNameAttribute(),
                ];
            }
        }

        set_time_limit(0);
        ini_set('memory_limit', '1G');

        Excel::create('Reporte_Personalizado_Campamentos - ' . Carbon::now() . '', function ($excel) use ($arrayExp) {

            $excel->sheet('Insc General', function ($sheet) use ($arrayExp) {

                $sheet->setBorder('A1:X1', 'thin', 'thin', 'thin', 'thin');
                $sheet->cells('A1:X1', function ($cells) {
                    $cells->setBackground('#F5F5F5');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');

                });

                $sheet->fromArray($arrayExp, null, 'A1', false, false);

            });
        })
//        ->store('xlsx',public_path());
            ->export('xlsx');

    }


    /**
     * Vista para generar  Credenciales de los alumnos
     * @param Request $request
     * @return mixed
     */
    public function getCredenciales(Request $request)
    {
        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
        $escenarioSelect = ['' => 'Seleccione el Pto Cobro *'] + Escenario::lists('escenario', 'id')->all();
        $moduloSelect = ['' => 'Seleccione el modulo *'] + Modulo::lists('modulo', 'id')->all();
        $modulo = $request->get('modulo');
        $escenario = $request->get('escenario');

        $start = new Carbon($start);
        $start = $start->toDateString();
        $end = new Carbon($end);
        $end = $end->toDateString();

        $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
            ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
            ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
            ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
            ->select('inscripcions.id', 'inscripcions.alumno_id', 'inscripcions.factura_id', 'inscripcions.calendar_id', 'user_id', 'inscripcions.escenario_id as insc_es', 'inscripcions.created_at')
            ->whereBetween('inscripcions.created_at', [$start, $end])
            ->where([
                ['modulo_id', $modulo],
                ['inscripcions.escenario_id', $escenario],
            ])
            ->whereNull('cart')//inscripciones internas sin las online
            ->orderBy('inscripcions.id', 'desc')
            ->paginate(8);

        return view('campamentos.reportes.credenciales.index', compact('inscripciones', 'start', 'end', 'escenarioSelect', 'escenario', 'modulo', 'moduloSelect'));
    }


    /**
     * Exportar Credenciales de Alumnos para imprimirlas
     * @param $id
     * @return mixed
     */
    public function exportCredenciales(Request $request)
    {
        $imp_cred = $request->get('imp_cred');
        if (!is_null($imp_cred)) {
            if (count($imp_cred) > 8) {
                return redirect()->back()->with('message_danger', 'No seleccionar mas de 8 inscripciones por pagina a imprimir');
            } else {
                $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
                    ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
                    ->join('programs', 'programs.id', '=', 'calendars.program_id')
                    ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
                    ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
                    ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
                    ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
                    ->select('inscripcions.id', 'inscripcions.alumno_id', 'inscripcions.factura_id', 'inscripcions.calendar_id', 'user_id', 'inscripcions.escenario_id as insc_es', 'inscripcions.created_at')
                    ->whereIn('inscripcions.id', $imp_cred)
                    ->get();
            }

            $pdf = PDF::loadView('campamentos.reportes.credenciales.credenciales-pdf', compact('inscripciones'))->setPaper('letter', 'landscape');
            return $pdf->stream('Credenciales');//imprime en pantalla
        } else {
            return redirect()->back()->with('message_danger', 'Seleccione las inscripciones a imprimir');
        }

    }


    /**
     * Obtener horarios para en select dinamico en el reporte general
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getHorario(Request $request)
    {

        if ($request->ajax()) {

            $escenario_id = $request->get('escenario');
            $disciplina_id = $request->get('disciplina');
            $modulo_id = $request->get('modulo');

            $program = Program::where('escenario_id', $escenario_id)
                ->where('disciplina_id', $disciplina_id)
                ->where('modulo_id', $modulo_id)->first();

            $horario = Calendar::
            join('horarios as h', 'h.id', '=', 'c.horario_id', 'as c')
                ->join('dias as d', 'd.id', '=', 'c.dia_id')
                ->select('h.start_time as start_time', 'h.end_time as end_time', 'h.activated', 'c.id as cID',
                    'h.id as hID', 'c.dia_id', 'c.horario_id', 'c.nivel', 'c.init_age', 'c.end_age')
                ->where('program_id', $program->id)
                ->where('h.activated', '1')
                ->groupBy('horario_id')
                ->orderBy('start_time')
                ->get()
                ->toArray();

            return response($horario);
        }
    }


    /**
     * Vista para Reporte del listado de los cursos
     * @param Request $request
     * @return mixed
     */
    public function getGeneral(Request $request)
    {
        $modulos_coll = Modulo::where('activated', true);
        $modulos = $modulos_coll->pluck('modulo', 'id');
//        $moduloSelect = ['' => 'Seleccione el modulo *'] + Modulo::lists('modulo', 'id')->all();
        $modulo = $request->get('modulo_id');
        $escenario = $request->get('escenario_id');
        $disciplina = $request->get('disciplina_id');
        $horario_id = $request->get('horario_id');

        if ($modulo != "") {
            $moduloSelect = Modulo::find($modulo);
        } else $moduloSelect = null;

        if ($escenario != "") {
            $escenarioSelect = Escenario::find($escenario);
        } else $escenarioSelect = null;

        if ($disciplina != "") {
            $disciplinaSelect = Disciplina::find($disciplina);
        } else  $disciplinaSelect = null;


        $cursos = Calendar::with('program', 'horario', 'dia', 'profesor')
            ->join('programs as p', 'p.id', '=', 'c.program_id', 'as c')
            ->join('dias as d', 'd.id', '=', 'c.dia_id')
            ->join('horarios as h', 'h.id', '=', 'c.horario_id')
            ->join('escenarios as e', 'e.id', '=', 'p.escenario_id')
            ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
            ->join('disciplinas as dis', 'dis.id', '=', 'p.disciplina_id')
            ->join('profesors as pro', 'pro.id', '=', 'c.profesor_id')
            ->select('program_id', 'profesor_id', 'dia_id', 'c.horario_id', 'cupos', 'contador', 'mensualidad', 'init_age', 'end_age', 'nivel', 'c.id', 'p.modulo_id', 'p.escenario_id', 'p.disciplina_id')
            ->where('modulo_id', $modulo)
            ->where('escenario_id', $escenario)
            ->where('disciplina_id', $disciplina)
            ->whereIn('horario_id', $horario_id)
            ->where('p.activated', '1')
            ->get();

        return view('campamentos.reportes.listado.index', compact('cursos', 'escenarioSelect', 'disciplinaSelect', 'horarioSelect', 'moduloSelect', 'modulos', 'escenario', 'disciplina', 'modulo', 'horario'));
    }

    /**
     * Exportar Reporte listado de los cursos
     * @param Request $request
     * @return mixed
     */
    public function exportGeneral(Request $request)
    {
        $data = $request->all();
        $curso_id = key($data);

        $curso = Calendar::findOrFail($curso_id);
        $numero = 1;

        $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno')
            ->join('calendars', 'calendars.id', '=', 'inscripcions.calendar_id')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->join('escenarios', 'escenarios.id', '=', 'programs.escenario_id')
            ->join('disciplinas', 'disciplinas.id', '=', 'programs.disciplina_id')
            ->join('horarios', 'horarios.id', '=', 'calendars.horario_id')
//            ->join('profesors', 'profesors.id', '=', 'calendars.profesor_id')
            ->join('dias', 'dias.id', '=', 'calendars.dia_id')
            ->select('inscripcions.id', 'inscripcions.alumno_id', 'inscripcions.factura_id', 'inscripcions.calendar_id', 'user_id', 'inscripcions.created_at', 'programs.disciplina_id', 'programs.escenario_id')
            ->where('calendar_id', $curso_id)
//            ->orderBy('inscripcions.created_at')
            ->get();

        $pdf = PDF::loadView('campamentos.reportes.listado.listado-pdf', compact('inscripciones', 'curso', 'numero'));
        return $pdf->stream('Listado');//imprime en pantalla
    }


    /**
     * Resumen de inscritos y Recaudacion,
     * Resumen de cobrado por eventos deportivos por modulo, no lo recolectado por pto de cobro
     * @param Request $request
     * @return mixed
     */
    public function getResumen(Request $request)
    {

        if (Auth::user()->hasRole(['planner', 'administrator', 'admin-cortesia'])) {

            $modulos_coll = Modulo::where('activated', true);
            $modulos = $modulos_coll->pluck('modulo', 'id');
            $modulo = $request->get('modulo');

            $inscripciones =
//                DB::table('inscripcions as i')
                Inscripcion::with('factura', 'calendar', 'user', 'alumno')
                    ->join('facturas as f', 'f.id', '=', 'inscripcions.factura_id')
                    ->join('calendars as c', 'c.id', '=', 'inscripcions.calendar_id')
                    ->join('programs as p', 'p.id', '=', 'c.program_id')
                    ->join('modulos as m', 'm.id', '=', 'p.modulo_id')
                    ->join('escenarios as e', 'e.id', '=', 'p.escenario_id')
                    ->join('disciplinas as d', 'd.id', '=', 'p.disciplina_id')
                    ->select('calendar_id', 'alumno_id', 'cart', 'inscripcions.id', 'factura_id', 'estado', 'e.escenario', 'f.total', 'd.disciplina')
                    ->where('modulo_id', $modulo)
                    ->where('estado', '=', 'Pagada')
                    ->whereNull('cart')
                    ->get();

//dd($inscripciones);
            //creo arreglo agrupado por escenarios
            $escenariosArray = [];
            foreach ($inscripciones as $insc) {
                $cont_comp = Inscripcion::where('factura_id', $insc->factura_id)->count();
                $escenario = $insc->escenario; //escenario donde practicara el deporte, no es el pto de cobro
                $disciplina = $insc->disciplina;
//                if ($cont_comp>1){
//                    $factura = round(($insc->total)/$cont_comp,3);
////                    round(($insc->factura->total) / $cont_comp, 3),
//                }else {$factura = $insc->total;}
//                $factura = round(($insc->total)/$cont_comp,3);
                $factura = ($insc->total) / $cont_comp;
                $escenariosArray[$escenario][] = [
                    "escenario" => $escenario,
                    "disciplina" => $disciplina,
                    "factura" => $factura,
                ];
            }
            $resumenEscenario = [];
            $precioFinal = 0;
            $totalInscritos = 0;
//            dd($escenariosArray);
            foreach ($escenariosArray as $key => $value) {//recorro cada escenario agrupado
                $precioGrupo = 0;
                $cont = 0;
                foreach ($escenariosArray[$key] as $row) {
                    //acumulados por escenario
                    $precioGrupo += $row['factura'];
                    $cont++;
//                   $pp= array_sum(array_map(function($item) {
//                        return $item['factura'];
//                    }, $escenariosArray[$key]));
//                    dd($pp);
                }
                //totales Finales
                $precioFinal += $precioGrupo;
                $totalInscritos += $cont;
                $resumenEscenario[$key] = [
                    "factura" => $precioGrupo,
                    "escenario" => $key,
                    "inscritos" => $cont,
                ];

//                $escenariosArray[$key]['acumulado'] = ["factura"=>$precioGrupo ];
            }
            $totalRecaudado = ["total" => $precioFinal];
            $totalInscritos = ["total" => $totalInscritos];
//            $escenariosArray['TotalesFinales'] = ["factura"=>$precioFinal];
//        $total = ["total" => $precioFinal ];

            /***************************************************************************************************************************************/
            //creo arreglo agrupado por escenarios y despues por disciplinas
            $array = [];
            foreach ($inscripciones as $insc) {
                $escenario = $insc->escenario;
                $disciplina = $insc->disciplina;
                $factura = $insc->total;
                $array[$escenario][] = [
                    "escenario" => $escenario,
                    "disciplina" => $disciplina,
                    "factura" => $factura,
                ];
            }
            $resumenEscenarioDisciplina = [];
            foreach ($array as $key => $value) {
                foreach ($array[$key] as $disc) {//recorriendo los valores en cada escenario
                    //acumulados por escenario
//                    $precioGrupo += $disc['factura'];
//                    $cont++;
                    $disciplina = $disc['disciplina'];
                    $resumenEscenarioDisciplina[$key][$disciplina][] = [ //agrupo por escenario y disciplina
                        "valor" => $disc['factura'],
                        "disciplina" => $disciplina,
                        "escenario" => $key,
                    ];
                }
//                $resumenEscenarioDisciplina[$key][$disciplina][]=["escenario"=>$key];
            }

            $resultado = [];
            $precio = 0;
            $contador = 0;
            foreach ($resumenEscenarioDisciplina as $key => $value) {

                foreach ($resumenEscenarioDisciplina[$key] as $r) {
//                    dd($r);
//                    $precio += $r['valor'];
                    $cont++;
//                    $disciplina=$r['disciplina'];
                    $resultado = [
                        "inscritos" => $cont,
                    ];
                }


            }
//            dd($resumenEscenarioDisciplina);

//            $array = [100, '200', 300, '400', 500];
//
//            $array = array_where($array, function ($key, $value) {
//                return is_string($value);
//            });


//            dd($resumenEscenarioDisciplina);

//            dd($resumenEscenarioDisciplina);

            return view('campamentos.reportes.recaudado', compact('modulos', 'modulo', 'resumenEscenario', 'totalRecaudado', 'totalInscritos', 'resumenEscenarioDisciplina'));
        } else return abort(403);
    }


    /**
     * Cargar vista para Generar Formato Facturación
     * @param Request $request
     * @return mixed
     */
    public function getFactura(Request $request)
    {
        $escenarios_coll = Escenario::all();
        $escenarioSelect = $escenarios_coll->pluck('escenario', 'id');
//        $escenarioSelect = ['' => 'Pto de Cobro'] + Escenario::lists('escenario', 'id')->all();

        $escenario = $request->get('escenario');

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        $start = new Carbon($start);
        $start = $start->toDateString();
        $end = new Carbon($end);
        $end = $end->toDateString();


        if ($escenario) {
            $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
                ->whereBetween('created_at', [$start, $end])
                ->where('escenario_id', $escenario)//pto cobro
                ->where('estado', 'Pagada')
                ->orderBy('created_at')
                ->groupBy('factura_id')
                ->paginate(5);

        } else {
            $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
                ->whereBetween('created_at', [$start, $end])
//                ->where('escenario_id','like', '%'.$escenario.'%')
                ->where('estado', 'Pagada')
                ->orderBy('created_at')
                ->groupBy('factura_id')
                ->paginate(5);
        }

        return view('campamentos.reportes.reporte-factura', compact('inscripciones', 'start', 'end', 'escenarioSelect', 'escenario'));
    }


    /**
     * Exportar excel Generar Formato Facturación
     * @param Request $request
     */

    public function exportFactura(Request $request)
    {

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
        $escenario = $request->get('escenario');

        $start = new Carbon($start);
        $start = $start->toDateString();
        $end = new Carbon($end);
        $end = $end->toDateString();

        if ($escenario) {
            $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
                ->whereBetween('created_at', [$start, $end])
                ->where('escenario_id', $escenario)//pto cobro
                ->where('estado', 'Pagada')
                ->orderBy('created_at')
                ->groupBy('factura_id')
                ->get();
        } else {
            $inscripciones = Inscripcion::with('factura', 'calendar', 'user', 'alumno', 'escenario')
                ->whereBetween('created_at', [$start, $end])
//                ->where('escenario_id','like', '%'.$escenario.'%')
                ->where('estado', 'Pagada')
                ->orderBy('created_at')
                ->groupBy('factura_id')
                ->get();
        }

        $arrayExp[] = ['codigopadre', 'codigo', 'nombre', 'nombrecomercial', 'RUC', 'Fecha', 'Referencia', 'Comentario',
            'CtaIngreso', 'Cantidad', 'Valor', 'Iva', 'DIRECCION', 'division', 'TipoCli', 'actividad', 'codvend', 'recaudador',
            'formadepago', 'estado', 'diasplazo', 'precio', 'telefono', 'fax', 'celular', 'e_mail', 'pais', 'provincia', 'ciudad',
            'CtaxCob', 'CtaxAnt', 'cupo', 'empresasri'
        ];

        foreach ($inscripciones as $insc) {

            $arrayExp[] = [
                'codigopadre' => '',
                'codigo' => '',
                'nombre' => $insc->factura->representante->persona->getNombreAttribute(),
                'nombrecomercial' => $insc->factura->representante->persona->getNombreAttribute(),
                'RUC' => (int)$insc->factura->representante->persona->num_doc,
                'Fecha' => (string)$insc->factura->created_at->format('d/m/Y'),
                'Referencia' => 'INSCRIPCION CAMPAMENTOS' . '-' . $insc->calendar->program->disciplina->disciplina . '-' . $insc->calendar->program->escenario->escenario,
                'Comentario' => $insc->factura->id,
                'CtaIngreso' => '6252499006133',
                'Cantidad' => 1,
                'Valor' => (float)$insc->factura->total,
                'Iva' => 'S',
                'DIRECCION' => $insc->factura->representante->persona->direccion,
                'division' => (int)$insc->escenario->codigo,
                'TipoCli' => 1,
                'actividad' => 1,
                'codvend' => '',
                'recaudador' => '',
                'formadepago' => $insc->factura->pago->forma,
                'estado' => 'A',
                'diasplazo' => 1,
                'precio' => 1,
                'telefono' => (string)$insc->factura->representante->persona->telefono,
                'fax' => '',
                'celular' => '',
                'e_mail' => $insc->factura->representante->persona->email,
                'pais' => 1,
                'provincia' => 1,
                'ciudad' => 4,
                'CtaxCob' => '1110101001',
                'CtaxAnt' => '2120307999',
                'cupo' => 500,
                'empresasri' => 'PERSONAS NO OBLIGADAS A LLEVAR CONTABILIDAD, FACTURA',

            ];
        }

        set_time_limit(0);
        ini_set('memory_limit', '1G');
        Excel::create('Facturacion_Masiva - ' . Carbon::now() . '', function ($excel) use ($arrayExp) {

            $excel->sheet('Facturacion', function ($sheet) use ($arrayExp) {

//                $sheet->setBorder('A1:AG','thin', 'thin', 'thin', 'thin');
//                $sheet->cells('A1:AG', function($cells){
//                    $cells->setBackground('#F5F5F5');
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//
//                });

                $sheet->setColumnFormat(array(
                    'A' => 'General',
                    'B' => 'General',
                    'C' => 'General',
                    'D' => 'General',
                    'E' => '0',
                    'F' => '@',
                    'I' => '@',
                    'K' => '#,##0.00_-',
                    'N' => '0',
                    'O' => '0',
                    'P' => '0',
                    'U' => '0',
                    'V' => '0',
                    'AA' => '0',
                    'AB' => '0',
                    'AC' => '0',
                    'AF' => '#,##0.00_-',
                    'AD' => 'General',
                    'AE' => 'General',

                ));

                $sheet->fromArray($arrayExp, null, 'A1', false, false);

            });
        })->export('xlsx');

    }


}
