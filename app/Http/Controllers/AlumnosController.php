<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Persona;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class AlumnosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $alumnos=Alumno::all();
        }

        return view('campamentos.alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

//        $encuestas=[] + Encuesta::lists('encuesta', 'id')->all();
        return view('campamentos.alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        try {
            DB::beginTransaction();

            $persona=new Persona;
            $persona->nombres=$request->get('nombres');
            $persona->apellidos=$request->get('apellidos');
            $persona->tipo_doc=$request->get('tipo_doc');
            $persona->num_doc=$request->get('num_doc');
            $persona->genero=$request->get('genero');
            $persona->fecha_nac=$request->get('fecha_nac');
//            $persona->email=$request->get('email');
            $persona->direccion=$request->get('direccion');
//            $persona->telefono=$request->get('telefono');
            $persona->save();

//            $encuesta_id=$request->get('encuesta_id');
//            $encuesta=Encuesta::find($encuesta_id);

            $alumno=new Alumno;
            $alumno->persona()->associate($persona);
//            $representante->encuesta()->associate($encuesta);

            if ($request->hasFile('foto_ced')) {
                $file = $request->file('foto_ced');
                $name='alumno_ced_'.time().'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/alumnos/cedula/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $alumno->foto_ced=$name;//ahora se guarda  en el atributo foto_ced la imagen
            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $name='alumno_perfil_'.time().'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/alumnos/perfil/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $alumno->foto=$name;//ahora se guarda  en el atributo foto_ced la imagen
            }


            $discapacitado=$request->get('discapacitado');
            if ($discapacitado){
                $alumno->discapacitado='SI';
            }else {
                $alumno->discapacitado='NO';
            }
           
            $alumno->save();

//            dd($alumno);
            DB::commit();

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }

        Session::flash('message', 'Alumno creado correctamente');
        return redirect()->route('admin.alumnos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumno=Alumno::findOrFail($id);
        return view('campamentos.alumnos.show',compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumno=Alumno::findOrFail($id);

        return view('campamentos.alumnos.edit',compact('alumno'));
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
        $validator = $this->validatorUpdate($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        try {
            DB::beginTransaction();

            $alumno=Alumno::findOrFail($id);
            $persona=$alumno->persona;

            $persona->nombres=$request->get('nombres');
            $persona->apellidos=$request->get('apellidos');
            $persona->tipo_doc=$request->get('tipo_doc');
            $persona->num_doc=$request->get('num_doc');
            $persona->genero=$request->get('genero');
            $persona->fecha_nac=$request->get('fecha_nac');
            $persona->email=$request->get('email');
            $persona->direccion=$request->get('direccion');
            $persona->telefono=$request->get('telefono');
            $persona->update();


            if ($request->hasFile('foto_ced')) {
                $file = $request->file('foto_ced');
                $name='alumno_ced_'.time().'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/alumnos/cedula/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $alumno->foto_ced=$name;//ahora se guarda  en el atributo foto_ced la imagen

            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $name='alumno_perfil_'.time().'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/alumnos/perfil/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $alumno->foto=$name;//ahora se guarda  en el atributo foto_ced la imagen
            }

            $alumno->discapacitado=$request->get('discapacitado');
            $alumno->update();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        Session::flash('message', 'Alumno '.$alumno->persona-> getNombreAttribute().' actualizado');
        return redirect()->route('admin.alumnos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alumno=Alumno::findOrFail($id);
        $persona=$alumno->persona;

        $persona->alumnos()->delete();
        $persona->delete();

        return back();
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];

        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['genero'] = 'required';
        $out['fecha_nac'] = 'required';
        $out['email'] = 'email|unique:personas';
        $out['direccion'] = 'max:255';
        $out['telefono'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'image|max:1000';
        $out['foto'] = 'image|max:150';
//        $out['discapacitado'] = 'required';

        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'Cedula':
                $out['num_doc'] = 'required|digits:10 | unique:personas';
                break;
            case 'Pasaporte':
                $out['num_doc'] = 'required|alpha_num |max:8 |min:5| unique:personas';
                break;
            case 'NoDoc':
                $out['num_doc'] = 'required|alpha_num |max:5 |min:3| unique:personas';
                break;
        }

        //Retornar la variable $out auxiliar
        return Validator::make($data, $out);
    }


    protected function validatorUpdate(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];

        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['genero'] = 'required';
        $out['fecha_nac'] = 'required';
        $out['email'] = 'email';
        $out['direccion'] = 'max:255';
        $out['telefono'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'max:1000';
        $out['foto'] = 'max:150';
//        $out['discapacitado'] = 'required';

        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'Cedula':
                $out['num_doc'] = 'required|digits:10';
                break;
            case 'Pasaporte':
                $out['num_doc'] = 'required|alpha_num |max:8 |min:5';
                break;
            case 'NoDoc':
                $out['num_doc'] = 'required|alpha_num |max:5 |min:3';
                break;
        }

        //Retornar la variable $out auxiliar
        return Validator::make($data, $out);
    }

}
