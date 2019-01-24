<?php

namespace App\Http\Controllers;

use App\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Http\Requests;

class ProfesorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
         
            $profesors = Profesor::where('status',Profesor::ACTIVO)->with('calendars')->get();
            return view('campamentos.profesors.index', ['profesors' => $profesors]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campamentos.profesors.create');
    }


    protected function validator(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];
        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['num_doc'] = 'required';
        
        //Retornar la variable $out auxiliar
        return Validator::make($data, $out);
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasRole(['planner','administrator'])) {
            
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
             
            $profesor=new Profesor();
            $profesor->nombres=strtoupper($request->get('nombres'));
            $profesor->apellidos=strtoupper($request->get('apellidos'));
            $profesor->num_doc=$request->get('num_doc');
            $profesor->save();
            
            Session::flash('message', 'Profesor creado correctamente');
            return redirect()->route('admin.profesors.index');
            
        }else return abort(403);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profesor=Profesor::with('calendars')->where('id',$id)->first();

        return view('campamentos.profesors.edit',['profe'=>$profesor]);
    }



    protected function validatorUpdate(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];
        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['num_doc'] = 'required';

        //Retornar la variable $out auxiliar
        return Validator::make($data, $out);
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->hasRole(['planner','administrator'])){

            $validator = $this->validatorUpdate($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            
            $profe=Profesor::findOrFail($id);
            $profe->nombres=strtoupper($request->get('nombres'));
            $profe->apellidos=strtoupper($request->get('apellidos'));
            $profe->num_doc=$request->get('num_doc');
            $profe->update();

            Session::flash('message', 'Profesor '.$profe->getNameAttribute().' actualizado');
            return redirect()->route('admin.profesors.index');
        }else return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profe=Profesor::findOrFail($id);
        $profe->status=Profesor::INACTIVO;
        $profe->update();

        Session::flash('message_danger', 'El profesor '.$profe->getNameAttribute().' ha sido deshabilitado');
        return redirect()->route('admin.profesors.index');
    }
}
