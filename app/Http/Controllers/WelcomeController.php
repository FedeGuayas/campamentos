<?php

namespace App\Http\Controllers;

use App\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class WelcomeController extends Controller
{
    public function __construct()
    {
        Carbon::setlocale('es');
    }

    /** Muestra los cursos en la pantalla de bienvenida
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request)
    {
        Carbon::setlocale('es');
        setlocale(LC_TIME, 'es_ES.utf8');
        $fecha_actual = Carbon::today();
        $year = $fecha_actual->year;
        $month = $fecha_actual->month;

        $cursos = Calendar::with('program', 'dia', 'horario')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->where('inicio', '>', $fecha_actual)
//          ->take(5)
            ->get();

//  dd($cursos);
        return view('welcome', compact('cursos', 'year', 'month'));
    }


    public function searchCurso(Request $request)
    {
        $termino = $request->termino;
        $fecha_actual = Carbon::today();

        $cursos = Calendar::with('program', 'dia', 'horario')
            ->whereHas('program', function ($query) use ($termino, $fecha_actual) {
                $query->where('activated', '=', '1')
                    ->whereHas('disciplina', function ($query) use ($termino, $fecha_actual) {
                        $query->where('disciplina', 'LIKE', "%$termino%");
                    })
                ->whereHas('modulo', function ($query) use ($fecha_actual) {
                    $query ->where('inicio', '>', $fecha_actual)
                        ->where('activated','=','1');
                });
            })
            ->paginate(3);
//            ->take(5)
//            ->get();
//dd($cursos);
        return view('search-result', compact('termino','cursos'));
    }


}
