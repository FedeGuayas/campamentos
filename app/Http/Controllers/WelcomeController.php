<?php

namespace App\Http\Controllers;

use App\Calendar;
use Illuminate\Http\Request;

use App\Http\Requests;

class WelcomeController extends Controller
{
    public function welcome(Request $request)
    {
        $cursos=Calendar::with('program','dia','horario')->get();
//        dd($cursos);
        return view('welcome',compact('cursos'));
    }
}
