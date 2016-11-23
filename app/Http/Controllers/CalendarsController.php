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
//        $calendar->nivel=$request->get('nivel');
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
//        $calendar->program_id=$request->get('program_id');
//        $calendar->dia_id=$request->get('dia_id');
//        $calendar->horario_id=$request->get('horario_id');
//        $calendar->cupos=$request->get('cupos');
//        $calendar->mensualidad=$request->get('mensualidad');
//        $calendar->nivel=$request->get('nivel');

        $calendar->update($request->all());
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
                ->where('d.activated',true)->get()->toArray();
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
                    'h.id as hID','c.dia_id','c.horario_id','c.nivel')
                ->where('program_id',$program->id)
                ->where('c.dia_id',$dia_id)
                ->where('h.activated',true)->get()->toArray();

            return response($horario);
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
        $cart->add($product,$product->id);//Agrego este producto(Programa+Calendario) al carrito

        //pongo el carrito en la session
        $request->session()->put('cart',$cart);
//        dd($request->session()->get('cart'));
        return redirect()->route('admin.inscripcions.create ');
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

        return redirect()->route('product.shoppingCart');//product.shoppingCart Vista detallada del carrito
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
        return redirect()->route('product.shoppingCart');
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
            return view('shop.shopping-cart');
        }
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        return view('shop.shopping-cart',['products'=>$cart->items,'totalPrice'=>$cart->totalPrice]);
    }

    /**
     * Obtengo la vista para la facturacion
     *
     * @return mixed
     *
     */
    public function getCheckout()
    {
        if (!Session::has('cart')){
            return view('shop.shopping-cart');
        }
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        $total=$cart->totalPrice;
        return view('shop.checkout',['total'=>$total]);
    }


}
