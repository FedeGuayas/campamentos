<?php

namespace App\Http\Controllers;



use App\Alumno;
use Event;
use App\Encuesta;
use App\Events\EncuestaRespondida;
use App\Persona;
use App\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use DB;


use App\Http\Requests;

class RepresentantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $representantes=Representante::all();
        }
 
        return view('campamentos.representantes.index', compact('representantes'));
    }

  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $encuestas=[] + Encuesta::lists('encuesta', 'id')->all();
        return view('campamentos.representantes.create',compact('encuestas'));
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
        $out['email'] = 'email|required|unique:personas';
        $out['direccion'] = 'required|max:255';
        $out['telefono'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'required|image|max:1000';
        $out['foto'] = 'required|image|max:150';
        $out['phone'] = 'required|max:15';

        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'Cedula':
                $out['num_doc'] = 'required|digits:10 | unique:personas';
                break;
            case 'Pasaporte':
                $out['num_doc'] = 'required|alpha_num |max:8 |min:5| unique:personas';
                break;
        }

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
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

            try {
                DB::beginTransaction();

                $persona = new Persona;
                $persona->nombres = $request->get('nombres');
                $persona->apellidos = $request->get('apellidos');
                $persona->tipo_doc = $request->get('tipo_doc');
                $persona->num_doc = $request->get('num_doc');
                $persona->genero = $request->get('genero');
                $persona->fecha_nac=$request->get('fecha_nac');
                $persona->email = $request->get('email');
                $persona->direccion = $request->get('direccion');
                $persona->telefono = $request->get('telefono');
                $persona->save();

                $encuesta_id = $request->get('encuesta_id');
                $encuesta = Encuesta::find($encuesta_id);

                $representante = new Representante;
                $representante->persona()->associate($persona);
                $representante->encuesta()->associate($encuesta);

                if ($request->hasFile('foto_ced')) {
                    $file = $request->file('foto_ced');
                    $name = 'rep_ced_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/dist/img/representantes/cedula/';//ruta donde se guardara
                    $file->move($path, $name);//lo copio a $path con el nombre $name
                    $representante->foto_ced = $name;//ahora se guarda  en el atributo foto_ced la imagen
                }
                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $name = 'rep_perfil_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/dist/img/representantes/perfil/';//ruta donde se guardara
                    $file->move($path, $name);//lo copio a $path con el nombre $name
                    $representante->foto = $name;//ahora se guarda  en el atributo foto_ced la imagen
                }

                $representante->phone = $request->get('phone');
                $representante->save();

                DB::commit();

                if ($encuesta) {
                    Event::fire(new EncuestaRespondida($encuesta));
                }

                if ($request->ajax()){
                    return response()->json([
                        'message'=>'Representante creado correctamente',
                        'representante_id'=>$representante->id,
                        'nombre'=>$persona->getNombreAttribute(),
                    ]);
                }

            } catch (\Exception $e) {
                DB::rollback();
            }

        Session::flash('message', 'Representante creado correctamente');
        return redirect()->route('admin.representantes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $representante=Representante::find($id);
        return view('campamentos.representantes.show',compact('representante'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $representante=Representante::findOrFail($id);

        return view('campamentos.representantes.edit',compact('representante'));
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
        $out['phone'] = 'required|max:15';

        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'Cedula':
                $out['num_doc'] = 'required|digits:10';
                break;
            case 'Pasaporte':
                $out['num_doc'] = 'required|alpha_num |max:8 |min:5';
                break;
        }

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
        $validator = $this->validatorUpdate($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        try {
            DB::beginTransaction();

            $representante=Representante::findOrFail($id);
            $persona=$representante->persona;

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
                $name='rep_ced_'.time().'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/representantes/cedula/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $representante->foto_ced=$name;//ahora se guarda  en el atributo foto_ced la imagen

            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $name='rep_perfil_'.time().'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/representantes/perfil/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $representante->foto=$name;//ahora se guarda  en el atributo foto_ced la imagen
            }

            
            $representante->phone=$request->get('phone');
            $representante->update();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        Session::flash('message', 'Representante '.$representante->persona-> getNombreAttribute().' actualizado');
        return redirect()->route('admin.representantes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $representante=Representante::findOrFail($id);
        $persona=$representante->persona;

        $flag=$representante->alumnos;

        if (count($flag)>0){
            Session::flash('message_danger', 'No puede eliminar a '.$representante->persona-> getNombreAttribute().' mientras este representando alumnos');
        } else{
            $persona->representantes()->delete();
            $persona->delete();
            Session::flash('message', 'Se elimino al representante '.$representante->persona-> getNombreAttribute().'');
        }
        return back();
    }

    public function beforeSearch(Request $request)
    {
       $search=trim($request->get('datos'));
        if($request->ajax()) {
            return  redirect()->route('admin.representantes.search', ['search' => $search]);
        }else {
            return redirect()->back();
        }

    }

    public function search($search)
    {
        $query=trim($search);
        if ($query!=""){
            $representantes=Persona::searchPersona($search)->orderBy('created_at','DESC')->get();
        }

        return view('campamentos.alumnos.listSearch',compact('representantes'));

    }

    public function listSearch()
    {
        return view('campamentos.alumnos.listSearch');
    }



    /**
     *  Obtener los alumnos para un representnate para select dinamico
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getAlumnos(Request $request,$id){

        if ($request->ajax()){
//            $representante=Representante::where('persona_id',$id)->get();
            $alumnos=DB::table('alumnos as a')
                ->join('representantes as r','r.id','=','a.representante_id')
                ->join('personas as p','p.id','=','r.persona_id')
                ->select('p.nombres as nombres','p.apellidos as apellidos','a.id as aID','r.persona_id')
                ->where('a.representante_id',$id)
                ->get();
//            $categoria = ['' => 'Seleccione la categoría'] + Categoria::lists('categoria', 'id')->all();
//            $escenar = $escenarios->pluck('escenario', 'escenario_id');
dd($alumnos);
//            return response($alumnos);
        }
    }


    
}
