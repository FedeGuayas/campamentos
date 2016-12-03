<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Cart;
use App\Dia;
use App\Disciplina;
use App\Escenario;
use App\Horario;
use App\Modulo;
use App\Program;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Http\Requests\CalendarStoreRequest;


class CalendarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $calendars=Calendar::
            join('programs as p','p.id','=','c.program_id','as c')
            ->join('dias as d','d.id','=','c.dia_id')
            ->join('horarios as h','h.id','=','c.horario_id')
            ->join('escenarios as e','e.id','=','p.escenario_id')
            ->join('modulos as m','m.id','=','p.modulo_id')
            ->join('disciplinas as dis','dis.id','=','p.disciplina_id')
            ->select('e.escenario','dis.disciplina','m.modulo','d.dia','h.start_time','h.end_time','cupos','contador','mensualidad','c.id')
            ->where('p.activated',true)

            ->get();

        return view('campamentos.calendars.index',compact('calendars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data =   $request->all();
        $program_id=key($data);
        $program=Program::findOrFail($program_id);
        $escenario_id=$program->escenario_id;
        $disciplina_id=$program->disciplina_id;
        $modulo_id=$program->modulo_id;
        $escenario=Escenario::findOrFail($escenario_id);
        $disciplina=Disciplina::findOrFail($disciplina_id);
        $modulo=Modulo::findOrFail($modulo_id);
       
        $horarios=[] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario'), 'id')->lists('horario','id')->all();
        $dias=[]+ Dia::lists('dia','id')->all();
        
        return view('campamentos.calendars.create',compact('program','horarios','dias','escenario','disciplina','modulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarStoreRequest $request)
    {
        $calendar=new Calendar;
        $calendar->program_id=$request->get('program_id');
        $calendar->dia_id=$request->get('dia_id');
        $calendar->horario_id=$request->get('horario_id');
        $calendar->cupos=$request->get('cupos');
        $calendar->mensualidad=$request->get('mensualidad');
        $calendar->init_age=$request->get('init_age');
        $calendar->end_age=$request->get('end_age');
        $calendar->nivel=strtoupper($request->get('nivel'));
        $calendar->save();
        
        return redirect()->route('admin.programs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calendar=Calendar::findOrFail($id);
        $program=Program::findOrFail($calendar->program_id);
        $escenario_id=$program->escenario_id;
        $disciplina_id=$program->disciplina_id;
        $modulo_id=$program->modulo_id;
        $escenario=Escenario::findOrFail($escenario_id);
        $disciplina=Disciplina::findOrFail($disciplina_id);
        $modulo=Modulo::findOrFail($modulo_id);
        $horarios=[] + Horario::select(DB::raw('CONCAT(start_time, " - ", end_time) AS horario'), 'id')->lists('horario','id')->all();
        $dias=[]+ Dia::lists('dia','id')->all();

        return view('campamentos.calendars.edit',compact('calendar','horarios','dias','escenario','disciplina','modulo'));
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
        $calendar=Calendar::findOrFail($id);
        $calendar->dia_id=$request->get('dia_id');
        $calendar->horario_id=$request->get('horario_id');
        $calendar->cupos=$request->get('cupos');
        $calendar->mensualidad=$request->get('mensualidad');
        $calendar->init_age=$request->get('init_age');
        $calendar->end_age=$request->get('end_age');
        $calendar->nivel=strtoupper($request->get('nivel'));
        $calendar->update();
        return redirect()->route('admin.programs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *  Obtener los dias para un programa  para select dinamico
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getDias(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            $dias=Calendar::
                join('dias as d','d.id','=','c.dia_id','as c')
                ->select('d.dia as dias','d.activated','c.id as cID','d.id as dID',
                    'c.dia_id','c.horario_id','c.nivel','c.program_id')
                ->where('program_id',$program->id)
                ->where('d.activated',true)->groupBy('dID')->get()->toArray();
            return response($dias);
        }
    }

    /**
     * Obtener horarios para los dias
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getHorario(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            $horario=Calendar::
                join('horarios as h','h.id','=','c.horario_id','as c')
                ->join('dias as d','d.id','=','c.dia_id')
                ->select('h.start_time as start_time','h.end_time as end_time','h.activated','c.id as cID',
                    'h.id as hID','c.dia_id','c.horario_id','c.nivel', 'c.init_age','c.end_age')
                ->where('program_id',$program->id)
                ->where('c.dia_id',$dia_id)
                ->where('h.activated',true)->get()->toArray();

            return response($horario);
        }
    }


    /**
     * Obtener los niveles
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getNivel(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');
            $horario_id=$request->get('horario_id');

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            $nivel=Calendar::
               where('program_id',$program->id)
                ->where('dia_id',$dia_id)
                ->where('horario_id',$horario_id)->get()->toArray();

            $nivezxcvzxvcl=Calendar::
            join('horarios as h','h.id','=','c.horario_id','as c')
                ->join('dias as d','d.id','=','c.dia_id')
                ->select('c.id as cID','c.dia_id','c.horario_id','c.nivel')

                ->where('c.dia_id',$dia_id)
                ->where('c.horario_id',$horario_id)
               ->get()->toArray();


            return response($nivel);
        }
    }

    /**
     * Obtener el curso o calendario del formulario de inscripcion
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getCurso(Request $request){
        if ($request->ajax()){

            $escenario_id=$request->get('escenario');
            $disciplina_id=$request->get('disciplina');
            $modulo_id=$request->get('modulo');
            $dia_id=$request->get('dia_id');
            $horario_id=$request->get('horario_id');
            $calendar_id=$request->get('nivel');//xk en el value del select de nivel estoy pasando el calenadr_id

            $program=Program::where('escenario_id',$escenario_id)
                ->where('disciplina_id',$disciplina_id)
                ->where('modulo_id',$modulo_id)->first();

            $calendar=Calendar::findOrFail($calendar_id);

            $curso=Calendar::
            join('horarios as h','h.id','=','c.horario_id','as c')
                ->join('dias as d','d.id','=','c.dia_id')
                ->select('c.id as cID','c.program_id')
                ->where('c.program_id',$program->id)
                ->where('c.id',$calendar_id)
                ->where('c.dia_id',$dia_id)
                ->where('c.horario_id',$horario_id)
                ->get()->toArray();


            return response($curso);
        }
    }
    

    
    /*****PRODUCTO*****/

    /**
     * Adicionar Productos al carrito al dar en el boton de +
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */

    public function getAddToCart(Request $request,$id){

        $product=Calendar::findOrFail($id);

        //si hay un cart almacenado en la session lo tomo, sino le paso nulo
        $oldCart=Session::has('cart') ? Session::get('cart') : null;
        //creo una instancia del carrito
        $cart=new Cart($oldCart);
        $cart->add($product,$product->id);//Agrego este producto(+Calendario=calendar_id) al carrito
        //pongo el carrito en la session
        $request->session()->put('cart',$cart);

        $message='Curso agregado al carrito';
        if ($request->ajax()){
            return response()->json([
                'message'=>$message
            ]);
        }
//           dd($request->session()->get('cart'));
            return redirect()->route('admin.inscripcions.create ');


    }

    /**
     * El carrito en detalle
     *
     * @param Request $request
     * @return mixed
     */
    public function getCart(Request $request)
    {
        if (!Session::has('cart')){

            return view('campamentos.inscripcions.create');
        }
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        return view('campamentos.inscripcions.partials.detalle',['products'=>$cart->items,'totalPrice'=>$cart->totalPrice]);
    }


    /**
     * Quitar 1 solo Productos del Item en el carrito, uno a uno
     * @param $id
     * @return mixed
     */
    public function getReduceByOne($id){
        $oldCart=Session::has('cart') ? Session::get('cart') : null;
        $cart=new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items)>0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }

        return redirect()->route('admin.inscripcions.create');//product.shoppingCart Vista detallada del carrito
    }


    /**
     * Eliminar el item completo, Ejj tengo 3 inscripciones de gimnasi en el EM las elimina las 3
     *
     * @param $id
     * @return mixed
     */

    public function getRemoveItem($id){
        $oldCart=Session::has('cart') ? Session::get('cart') : null;
        $cart=new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items)>0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect()->route('admin.inscripcions.create');
    }


    /**
     * Obtengo la vista para la facturacion y hacer el pago
     *
     * @return mixed
     *
     */
    public function getCheckout()
    {
        if (!Session::has('cart')){
            return redirect()->route('admin.inscripcions.create');
        }
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        $total=$cart->totalPrice;
        return view('shop.checkout',['total'=>$total]);
    }

    /**
     * Realizar el pago online
     * @param Request $request
     * @return mixed
     */
    public function postCheckout(Request $request)
    {
        if (!Session::has('cart')){
            return redirect()->route('shopppingCart');
        }
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        Stripe::setApiKey('sk_test_yXZNh4Iswaypk4Jq2i9UugiP');//my test secret key for stripe
        try {
            //cargando la ordena a stripe
            //tomado de stripe, multiplicar *100 para que tenga en cuenta las centenas
            $charge=Charge::create(array(
                "amount" => $cart->totalPrice*100,
                "currency" => "usd",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Charge for james.smith@example.com"
            ));
            //almacenando la informacion de la orden en mi bd
            $order=new Order();
            $order->cart=serialize($cart);//serializo el objeto cart, para guaradrlo como string en la bd
            $order->address=$request->input('address');
            $order->name=$request->input('name');
            $order->payment_id=$charge->id; //tomo el id del response del stripe
            //Guardar en la bd segun la relacion establecida entre el usuario y la orden.

            Auth::user()->orders()->save($order);
        }catch(\Exception $e){
            return redirect()->route('checkout')->with('error',$e->getMessage());
        }

        Session::forget('cart');//limpiando la session, vaciando el carrito
        return redirect()->route('product.index')->with('success','Compra satisfactoria del producto');
    }

}
