<?php

namespace App\Http\Controllers;



use App\Alumno;
use App\Provincia;
use App\Worker;
use Event;
use App\Encuesta;
use App\Events\EncuestaRespondida;
use App\Persona;
use App\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use DB;


use App\Http\Requests;

class RepresentantesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:administrator'], ['only' => 'destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('campamentos.representantes.index');
    }


    /**
     * Obtener el listado de todos los representante para datatables con ajax
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request)
    {
        if ($request->ajax()){

            $representantes = Representante::with('persona','alumnos')
                ->select('representantes.*');


            $action_buttons = ' @if ( Auth::user()->can(\'edit_representante\'))
                                <a href="{{ route(\'admin.representantes.edit\', [$id] ) }}">
                                    {!! Form::button(\'<i class="tiny fa fa-pencil-square-o" ></i>\',[\'class\'=>\'label waves-effect waves-light teal darken-1\']) !!}
                                </a>
                                @endif
                                <a href="{{ route(\'admin.representantes.show\',[$id] ) }}">
                                    {!! Form::button(\'<i class="tiny fa fa-eye"></i>\',[\'class\'=>\'label waves-effect waves-light teal darken-1\']) !!}
                                </a>
                                @if ( Auth::user()->can(\'delete_representante\'))
                                <a href="{{ route(\'admin.representante.delete\',[$id] ) }}" onclick="
return confirm(\'Seguro que desea borrar al representante?\')">
                                {!! Form::button(\'<i class="tiny fa fa-trash-o" ></i>\',[\'class\'=>\'label waves-effect waves-light red darken-1\']) !!}
                                </a>
                 @endif
                       ';


            return Datatables::of($representantes)

                ->addColumn('actions', $action_buttons)

                ->addColumn('alumnos', function (Representante $representante) {
                    return $representante->alumnos->map(function($alumno) {
                        return $alumno->persona->getNombreAttribute();
                    })->implode('<br>');
                })->implode('<br>')
                ->filterColumn('alumnos', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(personas.nombres,'',personas.apellidos) like ?", ["%{$keyword}%"]);
                })
                ->addColumn('ci', function (Representante $representante) {
                    return $representante->alumnos->map(function($alumno) {
                        return ($alumno->persona->num_doc);
                    })->implode('<br>');
                })
                ->addColumn('canton', function ($alumno) {
                    if (count($alumno->persona->parroquia)>0){
                        return $alumno->persona->parroquia->canton->canton;
                    }else {
                        return '-';
                    }
                })->implode('<br>')
                ->filterColumn('canton', function ($query, $keyword) {
                    $query->whereRaw("cantons.canton like ?", ["%{$keyword}%"]);
                })

                ->make(true);
        }

        return view('campamentos.representantes.index');
    }

  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $encuestas=[] + Encuesta::lists('encuesta', 'id')->all();
        $provincias = Provincia::all();
        $list_provincias = $provincias->pluck('province', 'id');
        return view('campamentos.representantes.create',compact('encuestas','list_provincias'));
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
        $out['email'] = 'email|required';
        $out['direccion'] = 'required|max:255';
        $out['telefono'] = 'required|max:15';
        $out['phone'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'mimes:jpg,png,jpeg|max:1000';
        $out['foto'] = 'mimes:jpg,png,jpeg|max:150';
       

        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'CEDULA':
                $out['num_doc'] = 'required|digits:10 | unique:personas';
                break;
            case 'PASAPORTE':
                $out['num_doc'] = 'required|alpha_num |max:10 |min:5| unique:personas';
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
        if(Auth::user()->hasRole(['planner','administrator','signup'])){
        
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        try {
            DB::beginTransaction();

            $persona = new Persona;
            $persona->nombres = strtoupper($request->get('nombres'));
            $persona->apellidos = strtoupper($request->get('apellidos'));
            $persona->fecha_nac = $request->get('fecha_nac');
            $persona->tipo_doc = $request->get('tipo_doc');
            $persona->num_doc = $request->get('num_doc');
            $persona->genero = $request->get('genero');
            $persona->email = $request->get('email');
            $persona->direccion = strtoupper($request->get('direccion'));
            $persona->telefono = $request->get('telefono');
            $persona->phone = $request->get('phone');
            $persona->parroquia_id=$request->get('parroquia_id');
            $persona->save();

            $encuesta_id = $request->get('encuesta_id');
            $encuesta = Encuesta::find($encuesta_id);

            $representante = new Representante;

            $representante->persona()->associate($persona);
            $representante->encuesta()->associate($encuesta);

            if ($request->hasFile('foto_ced')) {
                $file = $request->file('foto_ced');
                $name = 'rep_ced_'.time().'.' . $file->getClientOriginalExtension();
                $path = public_path() . '/dist/img/representantes/cedula/';//ruta donde se guardara
                $file->move($path, $name);//lo copio a $path con el nombre $name
                $representante->foto_ced = $name;//ahora se guarda  en el atributo foto_ced la imagen
            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $name = 'rep_perfil_'.time().'.' . $file->getClientOriginalExtension();
                $path = public_path() . '/dist/img/representantes/perfil/';//ruta donde se guardara
                $file->move($path, $name);//lo copio a $path con el nombre $name
                $representante->foto = $name;//ahora se guarda  en el atributo foto_ced la imagen
            }
            $representante->save();

            DB::commit();

            if ($encuesta) {
                Event::fire(new EncuestaRespondida($encuesta));
            }

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Representante creado correctamente',
                    'persona_id' => $persona->id,//porque el id de persona es el necesario al almacenar la inscripcion
                    'nombre' => $persona->getNombreAttribute(),
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            $msgerror='Error al guardar los datos';
//            $msgerror=$e->getMessage();
            Session::flash('message_danger', $msgerror);
            return redirect()->back('admin.representantes.index');
        }

        Session::flash('message', 'Representante creado correctamente');
        return redirect()->route('admin.representantes.index');
        }else return abort(403);
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

        $provincias = Provincia::all();
        $list_provincias = $provincias->pluck('province', 'id');

        return view('campamentos.representantes.edit',compact('representante','list_provincias'));
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
        $out['telefono'] = 'required|max:15';
        $out['phone'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'mimes:jpg,png,jpeg|max:1000';
        $out['foto'] = 'mimes:jpg,png,jpeg|max:150';
        

        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'CEDULA':
                $out['num_doc'] = 'required|digits:10';
                break;
            case 'PASAPORTE':
                $out['num_doc'] = 'required|alpha_num |max:10 |min:5';
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
        if(Auth::user()->hasRole(['planner','administrator','signup'])){
            
        $validator = $this->validatorUpdate($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        try {
            DB::beginTransaction();

            $parroquia=$request->get('parroquia_id');

            $representante=Representante::findOrFail($id);
            $persona=$representante->persona;

            $persona->nombres=strtoupper($request->get('nombres'));
            $persona->apellidos=strtoupper($request->get('apellidos'));
            $persona->fecha_nac = $request->get('fecha_nac');
            $persona->tipo_doc=$request->get('tipo_doc');
            $persona->num_doc=$request->get('num_doc');
            $persona->genero=$request->get('genero');
            $persona->email=$request->get('email');
            $persona->direccion=strtoupper($request->get('direccion'));
            $persona->telefono=$request->get('telefono');
            $persona->phone=$request->get('phone');
            if($parroquia!=''){
                $persona->parroquia_id=$parroquia;
            }
            $persona->update();


            if ($request->hasFile('foto_ced')) {
                $file = $request->file('foto_ced');
                $name='rep_ced_'.$representante->id.'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/representantes/cedula/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $representante->foto_ced=$name;//ahora se guarda  en el atributo foto_ced la imagen

            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $name='rep_perfil_'.$representante->id.'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/representantes/perfil/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $representante->foto=$name;//ahora se guarda  en el atributo foto_ced la imagen
            }
            $representante->update();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        Session::flash('message', 'Representante '.$representante->persona-> getNombreAttribute().' actualizado');
        return redirect()->route('admin.representantes.index');
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

        $representante=Representante::findOrFail($id);
        $persona=$representante->persona;

        $flag=$representante->alumnos;
        
        if (count($flag)>0){
            Session::flash('message_danger', 'No puede eliminar a '.$representante->persona-> getNombreAttribute().' mientras este representando alumnos');
            return redirect()->back();
        } else{
            $persona->representantes()->delete();
            $persona->delete();
            Session::flash('message', 'Se elimino al representante '.$representante->persona-> getNombreAttribute().'');
            return  redirect()->route('admin.representantes.index');
        }
      
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
        $field=trim($search);
        if ($field!=""){

            $personas=Persona::whereHas('representantes',function ($query) use ($field) {
                $query->where('num_doc', 'LIKE', '%' . $field . '%')
                    ->orWhere('nombres', 'LIKE', '%' . $field . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $field . '%');})
                ->orderBy('created_at','DESC')->take(10)->get();

        }
//        $query=trim($search);
//        if ($query!=""){
//            $personas=Persona::searchPersona($search)->orderBy('created_at','DESC')->take(10)->get();
//        }

        return view('campamentos.alumnos.listSearch',compact('personas'));

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

            $representante=Representante::with('persona')
                ->where('persona_id',$id)->first();

            $trabajador=Worker::searchWorker($representante->persona->num_doc)->first();


            if ($trabajador)
                $descuento_empleado=true;
            else
                $descuento_empleado=false;


            $alumnos=Alumno::
                join('personas as p','p.id','=','persona_id')
                ->select('alumnos.id as aID','p.nombres','p.apellidos')
                ->where('representante_id',$representante->id)
                ->get()->toArray();

            return response()->json([
                'alumnos'=>$alumnos,
                'representante'=>$representante,
                'descuento_empleado'=>$descuento_empleado,
            ]);
        }
    }


    
}
