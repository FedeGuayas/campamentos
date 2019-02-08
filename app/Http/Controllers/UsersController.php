<?php

namespace App\Http\Controllers;


use App\Escenario;
use App\Inscripcion;
use App\PagoMatricula;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserUpdateOnlineRequest;



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
            $usuarios=User::whereNull('escenario_id')->get();

        }

        return view('campamentos.users.index', compact('usuarios'));
    }

    /**
     * Trabajadores
     *
     * @return \Illuminate\Http\Response
     */
    public function trabajadores(Request $request)
    {
        if ($request){
            $trabajadores=User::has('escenario')->get();
        }

        return view('campamentos.users.trabajadores', compact('trabajadores'));
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
        $uri = Route::current()->getUri();
        $user=User::findOrFail($id);
        $escenarios_coll = Escenario::all();
        $escenarios= $escenarios_coll->pluck('escenario', 'id');
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();

        return view('campamentos.users.edit',compact('user','roles','escenarios','uri'));
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
        $uri=$request->uri;
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
//        return Redirect::to('admin/users');
        if ($uri == "admin/users/trabajadores/{users}/edit" || $user->has('escenario')){
            return redirect()->route('admin.users.trabajadores');
        }
        if ($uri == "admin/users/{users}/edit" ){
            return redirect()->route('admin.users.index');
        }
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
            $user->roles()->sync($roles);
//           // El usuario marcó checkbox
//            $user->roles()->sync($roles);
//
//        } else {
//           // El usuario no marcó checkbox, se le mantendra solo el rol de acceso al frontent
//            $role=Role::where('name', 'register')->first();
//            $user->attachRole($role);
     }
        $message='Roles del trabajador '.$user->getNameAttribute().' actualizados';
        return redirect()->route('admin.users.trabajadores')->with('message',$message)->withInput();
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
            ->paginate(5);

        $matriculas=PagoMatricula::with('inscripcion','factura','user','escenario')
            ->whereHas('factura', function($q) use($start,$end) {
                $q->whereBetween('created_at', [$start, $end]); //fecha de la factura
            })
//            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at')
            ->where('user_id',$user->id)
            ->limit(3)
            ->get();

        return view('campamentos.users.facturacion.reporte-factura-excell',compact('inscripciones','matriculas','start','end','user'));
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
            ->get();

        $matriculas=PagoMatricula::with('inscripcion','factura','user','escenario')
            ->whereHas('factura', function($q) use($start,$end) {
                $q->whereBetween('created_at', [$start, $end]); //fecha de la factura
            })
//            ->whereBetween('created_at', [$start, $end])
            ->where('user_id',$user->id)
            ->orderBy('created_at')
            ->get();

        $arrayExp[] = ['APELLIDOS ALUMNO.','NOMBRES ALUMNO','MODULO','ESCENARIO','COMPROBANTE','VALOR','DESCUENTO','CONCEPTO','FECHA COBRO','FORMA PAGO','PTO COBRO','USUARIO'
        ];

        foreach ($inscripciones as $insc) {

            if (!isset($insc->escenario)) {//online
                $pto_cobro = 'N/A';
            } else $pto_cobro = $insc->escenario->escenario;

            if ($insc->alumno_id == 0) {
                $alumno_nombre=$insc->factura->representante->persona->nombres;
                $alumno_apellidos=$insc->factura->representante->persona->apellidos;
            } else{
                $alumno_nombre=$insc->alumno->persona->nombres;
                $alumno_apellidos=$insc->alumno->persona->apellidos;
            }

            $cont_comp = Inscripcion::where('factura_id', $insc->factura_id)->count();

            $arrayExp[] = [
                'alum_ap' => $alumno_apellidos,
                'alum_nom' => $alumno_nombre,
                'modulo'=>$insc->calendar->program->modulo->modulo,
                'escenario'=>$insc->calendar->program->escenario->escenario,
                'comprobante'=>$insc->factura_id,
                'valor'=> round(($insc->factura->total) / $cont_comp, 3),
                'descuento'=>$insc->factura->descuento,
                'concepto'=>'Inscripcion',
                'fecha'=>$insc->factura->created_at->format('d/m/Y'),
                'formadepago'=> $insc->factura->pago->forma,
                'ptocobro'=>$pto_cobro,
                'usuario'=> $insc->user->getNameAttribute(),

            ];
        }

        foreach ($matriculas as $mat) {

            if (!isset($mat->escenario)) {
                $pto_cobro = 'N/A';
            } else $pto_cobro = $mat->escenario->escenario;

            if ($mat->inscripcion->alumno_id == 0) {
                $alumno_nombre=$mat->factura->representante->persona->nombres;
                $alumno_apellidos=$mat->factura->representante->persona->apellidos;
            } else{
                $alumno_nombre=$mat->inscripcion->alumno->persona->nombres;
                $alumno_apellidos=$mat->inscripcion->alumno->persona->apellidos;
            }

            $arrayExp[] = [
                'alum_ap' => $alumno_apellidos,
                'alum_nom' => $alumno_nombre,
                'modulo'=>$mat->inscripcion->calendar->program->modulo->modulo,
                'escenario'=>$mat->inscripcion->calendar->program->escenario->escenario,
                'comprobante'=>$mat->factura_id,
                'valor'=> (float)$mat->factura->total,
                'descuento'=>$mat->factura->descuento,
                'concepto'=>'Matricula',
                'fecha'=>$mat->factura->created_at->format('d/m/Y'),
                'formadepago'=> $mat->factura->pago->forma,
                'ptocobro'=>$pto_cobro,
                'usuario'=> $mat->user->getNameAttribute(),

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

                $sheet->setColumnFormat(array(
//                    'A'=>'General',
//                    'B'=>'General',
//                    'C'=>'General',
//                    'D'=>'General',
//                    'E' => '0',
                    'F' => '#,##0.00_-',
                    'G' => '#,##0.00_-',
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
                ));

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
