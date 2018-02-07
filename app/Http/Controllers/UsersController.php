<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Contable;
use App\Escenario;
use App\Inscripcion;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserUpdateOnlineRequest;
use App\Http\Requests;



class UsersController extends Controller
{

    public function __construct()
    {
        Carbon::setLocale('es');
        $this->middleware('auth');
        $this->middleware(['role:administrator'], ['only' => ['destroy','update','store','roles','setRoles','index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $usuarios=User::all();

        }

        return view('campamentos.users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $escenarios_coll = Escenario::all();
        $escenarios= $escenarios_coll->pluck('escenario', 'id');
        return view('campamentos.users.create',compact('escenarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user=new User;
        $escenario=Escenario::where('id',$request->get('escenario_id'))->first();
        $user->first_name=strtoupper($request->get('first_name'));
        $user->last_name=strtoupper($request->get('last_name'));
        $user->email=$request->get('email');
//        $user->escenario_id=$request->get('escenario_id');
        $user->password=$request->get('password');
//        $roles=$request->get('roles');
        $user->activated='1';
        $user->escenario()->associate($escenario);
        $user->save();

        Session::flash('message', 'Usuario creado correctamente');
        return Redirect::to('admin/users') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::findOrFail($id);
        return view('campamentos.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $escenarios_coll = Escenario::all();
        $escenarios= $escenarios_coll->pluck('escenario', 'id');
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        return view('campamentos.users.edit',compact('user','roles','escenarios'));
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
        $user=User::findOrFail($id);
        $escenario=Escenario::where('id',$request->get('escenario_id'))->first();
        $user->first_name=strtoupper($request->get('first_name'));
        $user->last_name=strtoupper($request->get('last_name'));
        $user->email=$request->get('email');
        $user->password=$request->get('password');
//        $roles=$request->get('roles');
//        $user->activated='1';
//        if ($roles) {
//            // El usuario marcó checkbox
//            $user->attachRole($roles);
//        }
//        else{
//            $user->detachRole($roles);
//        }
        $user->escenario()->associate($escenario);
        $user->update();

        $nombre=User::findOrFail($id)->getNameAttribute();
      
        Session::flash('message','Se actualizo el usuario '.$nombre);
        return Redirect::to('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();

        Session::flash('message','Usuario eliminado');
        return Redirect::to('admin/users');
    }

    /**
     * Muestra la vista con los roles que se pueden aplicar al usuario.
     *
     * $id de usuario
     * 
     */
    public  function roles($id)
    {
        $user=User::findOrFail($id);
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        $roles=Role::all();
        return view('campamentos.users.roles',compact('user','roles'));
    }

    /**
     * Addiconar o kitar los roles del usuario.
     *
     * $id de usuario
     *
     */    
    public  function setRoles(Request $request)
    {
        $user_id=$request->get('user_id');
        $user=User::findOrFail($user_id);
        $roles=$request->get('roles');
        
        if ($roles) {
            // El usuario marcó checkbox
            foreach ($roles as $rol){
                $user->attachRole($rol);
            }

        } else {
            // El usuario no marcó checkbox
                $user->detachRole($roles);
     }
        return Redirect::to('admin/users');
    }


    /**
     * Mostrar el perfi del usuario backend
     */
    public function showProfile()
    {
        $user=Auth::user();
        return view('campamentos.users.profile', compact('user'));
    }

   
    /**
     * Cargar vista para Generar Formato Facturación Masiva por usuario
     * @param Request $request
     * @return mixed
     */
    public function getFacturaExcel(Request $request)
    {

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
        $start=new Carbon($start);
        $start=$start->toDateString();
        $end=new Carbon($end);
        $end=$end->toDateString();
        $user=Auth::user();

        $inscripciones=Inscripcion::with('factura','calendar','user','alumno','escenario')
            ->whereHas('factura', function($q) use($start,$end) {
                $q->whereBetween('created_at', [$start, $end]); //fecha de la factura
            })
//            ->whereBetween('created_at',[$start, $end]) //fecha inscripcion
            ->where('user_id',$user->id)
            ->where('estado','Pagada')
            ->orderBy('created_at')
            ->groupBy('factura_id')
            ->get();

        return view('campamentos.users.facturacion.reporte-factura-excell',compact('inscripciones','start','end'));
    }


    /**
     * Exportar excel para Generar Formato Facturación Masiva por usuario
     * @param Request $request
     */

    public function exportFacturaExcel(Request $request){

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
        $start=new Carbon($start);
        $start=$start->toDateString();
        $end=new Carbon($end);
        $end=$end->toDateString();
        $user=Auth::user();

        $inscripciones=Inscripcion::with('factura','calendar','user','alumno','escenario')
            ->whereHas('factura', function($q) use($start,$end) {
                $q->whereBetween('created_at', [$start, $end]); //fecha de la factura
            })
//            ->whereBetween('created_at',[$start, $end]) //fecha inscripcion
            ->where('user_id',$user->id)
            ->where('estado','Pagada')
            ->orderBy('created_at')
            ->groupBy('factura_id')
            ->get();

        $arrayExp[] = ['Fecha Insc.','Representante','RUC','Dirección','Teléfono','Email','Alumno','Modulo','Horario','Escenario','Valor','Forma Pago',         'Registro','Pto Cobro'
        ];

        foreach ($inscripciones as $insc) {

            if (is_null($insc->escenario_id) || $insc->escenario_id == '0') {//online
                $pto_cobro = 'N/A';
            } else $pto_cobro = $insc->escenario->escenario;

            if ($insc->alumno_id == 0) {
                $alumno=$insc->factura->representante->persona->getNombreAttribute();
            } else{
                $alumno=$insc->alumno->persona->getNombreAttribute();
            }

            $cont_comp = Inscripcion::where('factura_id', $insc->factura_id)->count();

            $arrayExp[] = [
                'fecha'=>$insc->created_at->format('d/m/Y'),
                'repre'=>$insc->factura->representante->persona->getNombreAttribute(),
                'ruc'=> (int)$insc->factura->representante->persona->num_doc,
                'direccion'=>$insc->factura->representante->persona->direccion,
                'telefono'=> (string)$insc->factura->representante->persona->telefono,
                'e_mail'=> $insc->factura->representante->persona->email,
                'alumno'=>$alumno,
                'modulo'=>$insc->calendar->program->modulo->modulo,
                'horario'=>$insc->calendar->horario->start_time.' - '.$insc->calendar->horario->end_time,
                'escenario'=>$insc->calendar->program->escenario->escenario,
                'valor'=> round(($insc->factura->total) / $cont_comp, 3),
                'formadepago'=> $insc->factura->pago->forma,
                'insc'=>$insc->id,
                'ptocobro'=>$pto_cobro
            ];
        }

        Excel::create('Facturacion_Usuario - '.Carbon::now().'', function ($excel) use ($arrayExp) {

            $excel->sheet('Facturacion', function ($sheet) use ($arrayExp) {

//                $sheet->setBorder('A1:AG','thin', 'thin', 'thin', 'thin');
//                $sheet->cells('A1:AG', function($cells){
//                    $cells->setBackground('#F5F5F5');
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//
//                });

//                $sheet->setColumnFormat(array(
//                    'A'=>'General',
//                    'B'=>'General',
//                    'C'=>'General',
//                    'D'=>'General',
//                    'E' => '0',
//                    'F' => '0',
//                    'I'=>'@',
//                    'K'=>'#,##0.00_-',
//                    'N' => '0',
//                    'O' => '0',
//                    'P' => '0',
//                    'U' => '0',
//                    'V' => '0',
//                    'AA' => '0',
//                    'AB' => '0',
//                    'AC' => '0',
//                    'AF' => '#,##0.00_-',
//                    'AD'=>'General',
//                    'AE'=>'General',
//
//                ));

                $sheet->fromArray($arrayExp,null,'A1',false,false);
            });
        })->export('xlsx');

    }

    
    //****************USUARIOS ONLINE******************************//
    
    /**
     * Cargar el form para editar la contraseña del usuarioonline
     * @param Request $request
     * @return mixed
     */
    public function getPasswordEdit(Request $request){

        $user=$request->user();

        return view('online.users.profile.pass-edit',['user'=>$user]);
    }

    /**
     * Cambio de contraseña de usuario online
     *
     * @param ChangePasswordRequest $request
     * @param User $user
     * @return mixed
     */
    public function postPassword(ChangePasswordRequest $request,User $user){

        $new_pass=$request->password_new;
        $user->password = $new_pass;
        $user->update();
        return redirect()->back()->with('message','Contraseña Actualizada');
    }


    /**
     * Actualizar datos del usuario online
     * @param UserUpdateOnlineRequest $request
     * @param $id
     * @return mixed
     */
    public function updateOnline(UserUpdateOnlineRequest $request, $id)
    {
        
        $user=User::findOrFail($id);

        $user->first_name=strtoupper($request->get('first_name'));
        $user->last_name=strtoupper($request->get('last_name'));

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $name='user_avatar_'.$user->id.'.'.$file->getClientOriginalExtension();
            $path=public_path().'/dist/img/users/avatar/';//ruta donde se guardara
            $file->move($path,$name);//lo copio a $path con el nombre $name
            $user->avatar=$name;//ahora se guarda  en el atributo avatar el nombre de la imagen
        }
        
        $user->update();
        
        $message='Se actualizaron sus datos de usuario';

        if ($request->ajax()){
            return  response()->json(['message'=>$message]);
        }else{
            return redirect()->back()->with('message',$message);
        }

    }

}
