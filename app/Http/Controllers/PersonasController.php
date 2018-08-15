<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

use App\Http\Requests;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $representante=Representante::all();
            $personas=Persona::whereDoesntHave('representantes')->get();
        }

        return view('campamentos.personas.index', compact('personas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postRepresentante($id)
    {
//        $data =   $request->all();
//        $persona_id=key($data);

        $persona=Persona::findOrFail($id);
        $representante=new Representante;
        $representante->persona_id=$id;

        $representante->foto_ced="NULL";
        $representante->foto="NULL";
        $representante->phone=1;
        $representante->save();
        Session::flash('message','Persona asignada como representante');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $persona=Persona::findOrFail($id);
            $persona->delete();
            Session::flash('message', 'Se elimino  '.$persona-> getNombreAttribute().'');
        return back();
    }

    /**
     * Obtener las parroquias del id de provincia
     * @param $prov_id
     * @return mixed
     */
    public function getCanton($prov_id)
    {
        $cantones = DB::table('cantons')->select('canton', 'id')->where('province_id', $prov_id)->get();
        return $cantones;
//      $cantones2 = $cantones->pluck('canton', 'id');
//      return response()->json(['data'=>$cantones2],200);
    }
    public function getParroquia($canton_id)
    {
        $parroquias = DB::table('parroquias')->select('parroquia', 'id')->where('canton_id', $canton_id)->get();
        return $parroquias;
    }
}
