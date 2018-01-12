<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Encuesta;
use App\Events\EncuestaRespondida;
//use App\Events\Event;
use App\Http\Requests;
use App\Persona;
use App\Representante;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * Muestra la pagina principal del perfil, representantes, alumnos, inscripciones
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=$request->user();//usuario registrado
        
        $user_email=$user->email;//email del usuario logueado

        //Buscar al usuario en la tabla persona por su email, persona=> alumno o representante
        $persona=Persona::where('email',$user_email)->first();

        //Buscar si por el id del usuario tiene representante
        $repre_id=Representante::where('user_id',$user->id)->get();

        if (count($persona)>0){ //si se encuentra en persona por su email

            $representante=Representante::where('persona_id',$persona->id)->with('alumnos','facturas','encuesta','persona')->get();
            if (count($representante)>0){// se encontro en representante
                $msg_exist='';
                //Buscar alumnos de cada representante
                foreach ($representante as $rep){
                    $alumnos=Alumno::where('representante_id',$rep->id)->with('representante','persona')->get();
                }
            }
        }elseif (count($repre_id)>0){
            $representante=$repre_id;
            $msg_exist='';
            foreach ($representante as $rep){
                $alumnos=Alumno::where('representante_id',$rep->id)->with('representante','persona')->get();
            }
        }
        else{
            $representante=null;
            $alumnos=null;
            $msg_exist='Debe resgistarse como Representante para realizar inscripciones';
        }

        $encuesta=[] + Encuesta::lists('encuesta', 'id')->all();

//        if ($request->ajax()){
//            return response()->json(['msg_existe'=>$msg_exist]);
//        }

        return view('home',compact('user','encuesta','representante','msg_exist','alumnos'));
    }


    /**
     * Validaciones para los campos al crear representantes
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorRepresentanteCreate(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];

        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['genero'] = 'required';
        $out['fecha_nac'] = 'required';
        $out['email'] = 'email|required|unique:personas';
        $out['direccion'] = 'required|max:255';
        $out['telefono'] = 'required|max:15';
        $out['phone'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['encuesta_id'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'mimes:jpg,png,jpeg|max:1000|required';
        $out['foto'] = 'mimes:jpg,png,jpeg|max:150|required';


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
     * Guardar Representante online
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeRepresentante(Request $request)
    {
        if(Auth::user()->hasRole(['register'])){

            $validator = $this->validatorRepresentanteCreate($request->all());
            if ($validator->fails()) {

                $ced_unique = array_get($validator->failed(), 'num_doc.Unique');//verifico que el error sea de cedula existente
                if ($ced_unique){
                    return redirect()->back()->with('message_danger','No es posible guardar su información porque este documento de identidad ya se encuentra registrado. Verifique que este correcto el número o contáctenos para solucionar este inconveniente.');
                }

                $this->throwValidationException(
                    $request, $validator
                );
            }

            try {
                DB::beginTransaction();

                $persona = new Persona();
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
                $persona->save();

                $encuesta_id = $request->get('encuesta_id');
                $encuesta = Encuesta::find($encuesta_id);

                $representante = new Representante;

                $representante->persona()->associate($persona);
                $representante->encuesta()->associate($encuesta);
                $representante->user_id=Auth::user()->id;

                if ($request->hasFile('foto_ced')) {
                    $file = $request->file('foto_ced');
                    $name = 'rep_ced_'.time().'.'.$file->getClientOriginalExtension();
                    $path = public_path() . '/dist/img/representantes/cedula/';//ruta donde se guardara
                    $file->move($path, $name);//lo copio a $path con el nombre $name
                    $representante->foto_ced = $name;//ahora se guarda  en el atributo foto_ced la imagen
                }
                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $name = 'rep_perfil_' .time(). '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/dist/img/representantes/perfil/';//ruta donde se guardara
                    $file->move($path, $name);//lo copio a $path con el nombre $name
                    $representante->foto = $name;//ahora se guarda  en el atributo foto_ced la imagen
                }
                $representante->save();

                DB::commit();

                if ($encuesta) {
                    event(new EncuestaRespondida($encuesta));
                }


            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('message_danger', $e->getMessage());
            }

            return redirect()->back()->with('message', 'Representante creado correctamente');

        }else return abort(403);
    }


    protected function validatorUpdateRepresentante(array $data)
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
//        $out['foto_ced'] = 'required|mimes:jpg,png,jpeg|max:1000';
//        $out['foto'] = 'required|mimes:jpg,png,jpeg|max:150';


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

    /**
     * Actualizar representante online
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRepresentante(Request $request, $representante)
    {
//        dd($request->all());
        if(Auth::user()->hasRole(['register'])){

            $validator = $this->validatorUpdateRepresentante($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            try {
                DB::beginTransaction();

                $representante=Representante::findOrFail($representante);
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

                $representante->user_id=Auth::user()->id;
                $representante->update();

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
            }

            return redirect()->back()->with('message', 'Representante '.$representante->persona-> getNombreAttribute().' actualizado');
        }else return abort(403);
    }

    /**
     * Eliminar representante online
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRepresentante(Request $request,$id)
    {
        $user_id=$request->user()->id;

        $representante=Representante::findOrFail($id);
        $persona=$representante->persona;

        if ($representante->user_id==$user_id){//permitir eliminar solo su representantes

            if ($request->ajax()) {
                $flag=$representante->alumnos;
                if (count($flag)>0){
                    $message='No puede eliminar a '.$representante->persona-> getNombreAttribute().' mientras este representando alumnos';
                    return  response()->json(['resp'=>$message]);
                } else{
//                    $persona->representantes()->delete();
//                    $persona->delete();
                    $message='Se elimino al representante '.$representante->persona-> getNombreAttribute().'';
                    return  response()->json(['resp'=>$message]);
                }
            }
            
        } else return response()->json(['resp'=>'No tiene permisos para eliminar este representante']);
        
    }


    /**
     * Validaciones para crear los alumnos
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorAlumnoCreate(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];
//        $out['representante_id'] = 'required';
        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['genero'] = 'required';
        $out['fecha_nac'] = 'required';
//        $out['email'] = 'email|unique:personas';
//        $out['direccion'] = 'max:255';
//        $out['telefono'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'mimes:jpg,png,jpeg|max:1000|required';
        $out['foto'] = 'mimes:jpg,png,jpeg|max:150|required';

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
     * Guardar el alumno creado online
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAlumno(Request $request, $representante_id)
    {
        $representante=Representante::findOrFail($representante_id);
        
        if(Auth::user()->hasRole(['register'])){
            $validator = $this->validatorAlumnoCreate($request->all());
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
//                Session::flash('message_danger', $e->getMessage());
                Session::flash('message_danger', 'A ocurrido un error al crear al alumno');
                return redirect()->back();
            }
            Session::flash('message', 'Alumno creado correctamente');
            return redirect()->back();
        }else return abort(403);
    }

    /** Validar campos para actualizar alumno
     * @param array $data
     * @return mixed
     */
    protected function validatorUpdateAlumno(array $data)
    {
        //variable tipo arreglo en donde se haga el arreglo de validación final
        $out = [];

        $out['nombres'] = 'required | max:50';
        $out['apellidos'] = 'required | max:50';
        $out['genero'] = 'required';
        $out['fecha_nac'] = 'required';
//        $out['email'] = 'email';
//        $out['direccion'] = 'max:255';
//        $out['telefono'] = 'max:15';
        $out['tipo_doc'] = 'required';
        $out['num_doc'] = 'required';
        $out['foto_ced'] = 'required';
        $out['foto'] = 'required';

        //Hacer validación condicional dependiendo del tipo de documento a utilizar.
        switch($data['tipo_doc']){
            case 'CEDULA':
                $out['num_doc'] = 'required|digits:10';
                break;
            case 'PASAPORTE':
                $out['num_doc'] = 'required|alpha_num |max:8 |min:5';
                break;
        }

//        if ($data['foto_ced']){
//            $out['foto_ced'] = 'mimes:jpg,png,jpeg|max:1000';
//        }
//        if ($data['foto']){
//            $out['foto'] = 'mimes:jpg,png,jpeg|max:150';
//        }
        //Retornar la variable $out auxiliar
        return Validator::make($data, $out);
    }

    /**
     * Editar alumno
     * @param Request $request
     * @param $representante
     */
    public function updateAlumno(Request $request, $alumno_id)
    {
        $alumno=Alumno::findOrFail($alumno_id);
        $persona=$alumno->persona;
        $user_id=$request->user()->id;

        if(Auth::user()->hasRole(['register']) && $alumno->representante->user_id==$user_id){

            $validator = $this->validatorUpdateAlumno($request->all());

            if ($validator->fails()) {



                    dd('error');

                $this->throwValidationException(
                    $request, $validator
                );
            }
            try {
                DB::beginTransaction();

                $persona->nombres=strtoupper($request->get('nombres'));
                $persona->apellidos=strtoupper($request->get('apellidos'));
                $persona->tipo_doc=$request->get('tipo_doc');
                $persona->num_doc=$request->get('num_doc');
                $persona->genero=$request->get('genero');
                $persona->fecha_nac=$request->get('fecha_nac');
                $persona->direccion=strtoupper($request->get('direccion'));
                $persona->update();

//                $representante=Representante::where('persona_id',$request->get('persona_id'))->first();
                $alumno->persona()->associate($persona);
//                $alumno->representante()->associate($representante);

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
//                Session::flash('message_danger', $e->getMessage());
//                return redirect()->back();
            }
            Session::flash('message', 'Alumno '.$alumno->persona-> getNombreAttribute().' actualizado');
            return redirect()->back();
        }else return redirect()->back()->with('message_danger','No tiene permisos ');

    }


    /**
     * Eliminar alumno
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAlumno(Request $request,$id)
    {
        $alumno=Alumno::findOrFail($id);
        $persona=$alumno->persona;

        $message='Se elimino al alumno '.$alumno->persona->getNombreAttribute().'';
        return  response()->json(['resp'=>$message]);

        //no eliminar hasta hacer cambios y guardar en la tabla de inscripcion el id persona del alumno

//        $persona->alumnos()->delete();
//        $persona->delete();

    }



}
