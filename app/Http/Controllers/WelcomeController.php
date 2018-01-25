<?php

namespace App\Http\Controllers;

use App\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class WelcomeController extends Controller
{
    /** Muestra los cursos en la pantalla de bienvenida
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request)
    {
        $fecha_actual = Carbon::today();
        $year=$fecha_actual->year;
        $month=$fecha_actual->month;

        $cursos=Calendar::with('program','dia','horario')
            ->join('programs', 'programs.id', '=', 'calendars.program_id')
            ->join('modulos', 'modulos.id', '=', 'programs.modulo_id')
            ->where('inicio','>',$fecha_actual)
//          ->take(5)
            ->get();

//  dd($cursos);
        return view('welcome',compact('cursos','year','month'));
    }



}
