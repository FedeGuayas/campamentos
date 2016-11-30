<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 300); //5 minutes

use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;

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

            Excel::load(Input::file('persons'), function($reader) {

                foreach ($reader->get() as $result) {
                    Persona::create([
                        'nombres'=> $result->nombres,
                        'apellidos' =>$result->apellidos,
                        'tipo_doc' =>$result->tipo_doc,
                        'num_doc' =>$result->num_doc,
                        'genero' =>$result->genero,
                        'fecha_nac' =>$result->fecha_nac,
                        'email' =>$result->email,
                        'direccion' =>$result->direccion,
                        'telefono' =>$result->telefono
                    ]);
                }
            });
            Session::flash('message','Se importaron los datos');
        }else{
            Session::flash('message','Error al Importar');
        }
        return redirect()->back();
    }

    /**
     * Vaciar la tabla de la bd
     * @return
     */

    public function truncate()
    {
        DB::table('personas')->delete();

        Session::flash('message','Tabla personas vaciada');
        return redirect()->back();
    }


}

