<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Contable;
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

use App\Http\Requests;



class UsersController extends Controller
{

    public function __construct()
    {
        Carbon::setLocale('es');
        $this->middleware('auth');
        $this->middleware(['role:administrador'], ['only' => ['destroy','update','store','roles','setRoles','index']]);
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
//        $roles_coll = Role::all();
//        $roles = $roles_coll->pluck('display_name', 'id');
        return view('campamentos.users.create',compact('roles'));
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
        $user->first_name=strtoupper($request->get('first_name'));
        $user->last_name=strtoupper($request->get('last_name'));
        $user->email=$request->get('email');
        $user->password=$request->get('password');
//        $roles=$request->get('roles');
        $user->activated='1';
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
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        return view('campamentos.users.edit',compact('user','roles'));
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
//        $user->update();

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
     * Mostrar el perfi de usuario
     */
    public function showProfile()
    {
        $user=Auth::user();
        return view('campamentos.users.profile', compact('user'));
    }

   
    /**
     * Cargar vista para las facturas del usuario
     * @param Request $request
     * @return mixed
     */
    public function getFacturaExcel(Request $request)
    {

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
        $user=Auth::user();

        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')
            ->whereBetween('created_at',[$start, $end])
            ->where('user_id',$user->id)
            ->where('estado','Pagada')
            ->orderBy('created_at')
            ->groupBy('factura_id')
            ->get();

        return view('campamentos.users.facturacion.reporte-factura-excell',compact('inscripciones','start','end'));
    }


    /**
     * Exportar excel con formato de facturacion
     * @param Request $request
     */

    public function exportFacturaExcel(Request $request){

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
        $user=Auth::user();



        $inscripciones=Inscripcion::with('factura','calendar','user','alumno')
            ->whereBetween('created_at',[$start, $end])
            ->where('user_id',$user->id)
            ->where('estado','Pagada')
            ->orderBy('created_at')
            ->groupBy('factura_id')
            ->get();

        $arrayExp[] = ['codigopadre','codigo','nombre','nombrecomercial','RUC','Fecha','Referencia','Comentario',
            'CtaIngreso','Cantidad','Valor','Iva','DIRECCION','division','TipoCli','actividad','codvend','recaudador',
            'formadepago','estado','diasplazo','precio','telefono','fax','celular','e_mail','pais','provincia','ciudad',
            'CtaxCob','CtaxAnt','cupo','empresasri'
        ];

        foreach ($inscripciones as $insc) {



            if ($insc->alumno_id == 0) {

            } else{

            }

            $arrayExp[] = [

                'codigopadre'=>'',
                'codigo'=>'',
                'nombre'=> $insc->factura->representante->persona->getNombreAttribute(),
                'nombrecomercial'=> $insc->factura->representante->persona->getNombreAttribute(),
                'RUC'=> $insc->factura->representante->persona->num_doc,
                'Fecha'=> $insc->factura->created_at->format('d/m/Y'),
                'Referencia'=> 'INSCRIPCION CAMPAMENTOS'.'-'. $insc->calendar->program->disciplina->disciplina.'-'.$insc->calendar->program->escenario->escenario,
                'Comentario'=> $insc->factura->id,
                'CtaIngreso'=> '6252499006133',
                'Cantidad'=> '1',
                'Valor'=> $insc->factura->total,
                'Iva'=> 'S',
                'DIRECCION'=> $insc->factura->representante->persona->direccion,
                'division'=> $insc->calendar->program->escenario->codigo,
                'TipoCli'=> '1',
                'actividad'=> '1',
                'codvend'=> '',
                'recaudador'=> '',
                'formadepago'=> $insc->factura->pago->forma,
                'estado'=> 'A',
                'diasplazo'=> '1',
                'precio'=> '1',
                'telefono'=> $insc->factura->representante->persona->telefono,
                'fax'=> '',
                'celular'=> '',
                'e_mail'=> $insc->factura->representante->persona->email,
                'pais'=> '1',
                'provincia'=> '1',
                'ciudad'=> '4',
                'CtaxCob'=> '1110101001',
                'CtaxAnt'=> '2120307999',
                'cupo'=> '500,00',
                'empresasri'=> 'PERSONAS NO OBLIGADAS A LLEVAR CONTABILIDAD, FACTURA',

            ];
        }

        Excel::create('Facturacion_Masiva - '.Carbon::now().'', function ($excel) use ($arrayExp) {

            $excel->sheet('Facturacion', function ($sheet) use ($arrayExp) {

//                $sheet->setBorder('A1:AG','thin', 'thin', 'thin', 'thin');
//                $sheet->cells('A1:AG', function($cells){
//                    $cells->setBackground('#F5F5F5');
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//
//                });

                $sheet->setColumnFormat(array(

                    'B' => '0',
                    'E' => '0',
                    'F' => 'dd/mm/yy',
                    'I' => '0',
                    'N' => '0',
                    'O' => '0',
                    'P' => '0',
                    'U' => '0',
                    'V' => '0',
                    'AA' => '0',
                    'AB' => '0',
                    'AC' => '0',
                    'AF' => '#,##0.00_-',

                ));

                $sheet->fromArray($arrayExp,null,'A1',false,false);

            });
        })->export('xlsx');

    }



}
