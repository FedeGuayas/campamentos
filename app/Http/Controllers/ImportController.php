<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 300); //5 minutes

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;

class ImportController extends Controller
{

    /**
     * Mostrar vista de importar excel de personas.
     *
     */
    public function getPersonas()
    {
        return view('import.import_persons');
    }

    /**
     * almacenar el ecel importado en la bd.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function postPersonsImport(Request $request)
    {
        if ($request->file('persons')){
//            $file=$request->file('chip');
//            $name=$file->getClientOriginalName();
            Excel::load(Input::file('persons'), function($reader) {

                foreach ($reader->get() as $result) {
                    Result::create([
                        'first_name'=> $result->first_name,
                        'second_name' =>$result->second_name,
                        'last_name' =>$result->last_name,
                        'sex' =>$result->sex,
                        'category' =>$result->category,
                        'circuit' =>$result->circuit,
                        'chip' =>$result->chip,
                        'place' =>$result->place,
                        'time' =>$result->time
                    ]);
                }
            });
            Session::flash('message','Se importaron los datos');
        }else{
            Session::flash('message','Error al Importar');
        }
        return redirect()->route('result.index');
    }

    /**
     * Vaciar la tabla de la bd
     * @return
     */

    public function truncate()
    {
        DB::table('results')->delete();

        Session::flash('message','Tabla resultados vaciada');
        return redirect()->route('result.index');
    }


}

