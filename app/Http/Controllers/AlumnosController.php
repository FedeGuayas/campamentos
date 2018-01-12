<?php


namespace App\Http\Controllers;

use App\Alumno;
use App\Persona;
use App\Representante;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class AlumnosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:administrator'], ['only' => 'destroy']);//eliminar alumnos solo administrador
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('campamentos.alumnos.index');
    }

    /**
     * Obtener el listado de todos los alumnos para datatables con ajax
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request)
    {
        if ($request->ajax()){
            //        $alumnos=Alumno::with('persona')->take(10);
            $alumnos = Alumno::with('persona')->selectRaw('distinct alumnos.*')->limit(50);


            $action_buttons =
                '@if ( Auth::user()->can(\'edit_alumno\'))
                 <a href="{{ route(\'admin.alumnos.edit\', [$id] ) }}">
                 {!! Form::button(\'<i class="tiny fa fa-pencil-square-o" ></i>\',[\'class\'=>\'label waves-effect waves-light teal darken-1\']) !!}
                 </a>
                 @endif
                 <a href="{{ route(\'admin.alumnos.show\',[$id] ) }}">
                {!! Form::button(\'<i class="tiny fa fa-eye"></i>\',[\'class\'=>\'label waves-effect waves-light teal darken-1\']) !!}
                 </a>
                 @if ( Auth::user()->can(\'delete_alumno\'))
                <a href="{{ route(\'admin.alumnos.delete\',[$id] ) }}" onclick="
return confirm(\'Seguro que desea borrar al alumno?\')">
                 {!! Form::button(\'<i class="tiny fa fa-trash-o" ></i>\',[\'class\'=>\'label waves-effect waves-light red darken-1\']) !!}
                </a>
                 @endif
                 ';
            //{!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-[$id]"]) !!}
            return Datatables::of($alumnos)
                ->addColumn('actions', $action_buttons)

                ->make(true);
        }

        return view('campamentos.alumnos.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data =   $request->all();
        $representante_id=key($data);
        $representante=Representante::find($representante_id);

//        $encuestas=[] + Encuesta::lists('encuesta', 'id')->all();
        return view('campamentos.alumnos.create',compact('representante'));
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
        $out['persona_id'] = 'required';
        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['genero'] = 'required';
        $out['fecha_nac'] = 'required';
//        $out['email'] = 'email|unique:personas';
        $out['direccion'] = 'max:255';
//        $out['telefono'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'image|max:1000';
        $out['foto'] = 'image|max:150';



        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'CEDULA':
                $out['num_doc'] = 'required|digits:10 | unique:personas';
                break;
            case 'PASAPORTE':
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

        if(Auth::user()->hasRole(['planner','administrator','signup'])){
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        try {
            DB::beginTransaction();
            $persona=new Persona;
            $persona->nombres=strtoupper($request->get('nombres'));
            $persona->apellidos=strtoupper($request->get('apellidos'));
            $persona->tipo_doc=$request->get('tipo_doc');
            $persona->num_doc=$request->get('num_doc');
            $persona->genero=$request->get('genero');
            $persona->fecha_nac=$request->get('fecha_nac');

            $persona->save();

            $alumno=new Alumno;
             
            $representante=Representante::where('persona_id',$request->get('persona_id'))->first();

            $alumno->persona()->associate($persona);
            $alumno->representante()->associate($representante);

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

            $alumno->save();


            DB::commit();

            if ($request->ajax()){
                
                return response()->json([
                    'message'=>'Alumno creado correctamente',
                    'alumno_id'=>$alumno->id,
                    'nombre'=>$persona->getNombreAttribute(),
                ]);
            }

        } catch (\Exception $e) {
            
            DB::rollback();
                Session::flash('message_danger', $e->getMessage());
                return redirect()->back('admin.alumnos.index');
        }

        Session::flash('message', 'Alumno creado correctamente');
        return redirect()->route('admin.alumnos.index');
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
        if(Auth::user()->hasRole(['planner','administrator','signup'])){

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

            $persona->nombres=strtoupper($request->get('nombres'));
            $persona->apellidos=strtoupper($request->get('apellidos'));
            $persona->tipo_doc=$request->get('tipo_doc');
            $persona->num_doc=$request->get('num_doc');
            $persona->genero=$request->get('genero');
            $persona->fecha_nac=$request->get('fecha_nac');
            $persona->direccion=strtoupper($request->get('direccion'));
            $persona->update();


            $representante=Representante::where('persona_id',$request->get('persona_id'))->first();
            $alumno->persona()->associate($persona);
            $alumno->representante()->associate($representante);

            if ($request->hasFile('foto_ced')) {
                $file = $request->file('foto_ced');
                $name='alumno_ced_'.$alumno->id.'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/alumnos/cedula/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $alumno->foto_ced=$name;//ahora se guarda  en el atributo foto_ced la imagen
            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $name='alumno_perfil_'.$alumno->id.'.'.$file->getClientOriginalExtension();
                $path=public_path().'/dist/img/alumnos/perfil/';//ruta donde se guardara
                $file->move($path,$name);//lo copio a $path con el nombre $name
                $alumno->foto=$name;//ahora se guarda  en el atributo foto_ced la imagen
            }

            $alumno->update();


            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        Session::flash('message', 'Alumno '.$alumno->persona-> getNombreAttribute().' actualizado');
        return redirect()->route('admin.alumnos.index');
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
        dd('eliminar'.$id);//no eliminar hasta mejorar y guardar en la tabla de inscripcion el id persona del alumno
        $alumno=Alumno::findOrFail($id);
        $persona=$alumno->persona;

        $persona->alumnos()->delete();
        $persona->delete();

        return redirect()->route('admin.alumnos.index');
    }

    


    protected function validatorUpdate(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];

        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['genero'] = 'required';
        $out['fecha_nac'] = 'required';
//        $out['email'] = 'email';
        $out['direccion'] = 'max:255';
//        $out['telefono'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'max:1000';
        $out['foto'] = 'max:150';


        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'CEDULA':
                $out['num_doc'] = 'required|digits:10';
                break;
            case 'PASAPORTE':
                $out['num_doc'] = 'required|alpha_num |max:8 |min:5';
                break;
        }

        //Retornar la variable $out auxiliar
        return Validator::make($data, $out);
    }

}
