<?php
/**
 * Esta clase se utiliza para guardar la cantidad de productos en la sesscion y no hereda de elocuent
 * es un clase normal.
 *
 * Almacena los items en el carrito  de lo que se desea comprar(cantidad, precios, etc)
 */

namespace App;



class Multiples
{

    /**
     * Items -> Grupos del mismo producto, para agruparlos, inicialmente lo pongo vacio
     * Ejemplo: Items#1(tiene 3 Iphone5), Items#2(tiene 2 LG)
     */
    public $cursos=null; //grupos por cursos del mismo tipo

    public $totalCursos=0; //cantidad total de grupos

    public $totalPrecio=0; //Precio total de la inscripcion (todos los cursos)
    
    public $tipo_desc=null;
    
    public $desc_empleado=null;

    public $representante=null;
   
    
    //agregar al constructor xk hay k estar sobreescribiendo cada ves k se adiciona un producto
    public function __construct($oldCurso)
    {
        if ($oldCurso){
            $this->cursos=$oldCurso->cursos;
            $this->totalCursos=$oldCurso->totalCursos;
            $this->totalPrecio=$oldCurso->totalPrecio;
            $this->representante=$oldCurso->representante;
            $this->tipo_desc=$oldCurso->tipo_desc;
            $this->desc_empleado=$oldCurso->desc_empleado;
        }
    }

    public function addCursos($curso,$id,$opciones){ //$id=calendar_id=producto $item=curso completo
        
        //Creo un array de cursos, inicio en 0 xk se ira incrementando, almaceno el precio del curso, el curso, las opciones
        $storedCurso=['qty'=>0,'precio'=>$curso->mensualidad,'curso'=>$curso, 'matricula'=>0, 'alumno'=>[], 'matricula'=>0];

        if ($this->cursos){  //compruebo si tengo cursos en la coleccion

            if (array_key_exists($opciones[0]['alumno']['id'],$storedCurso['alumno'])){
                $storedCurso['alumno']=$storedCurso['alumno'][$opciones[0]['alumno']['id']];//esta linea sobreescribe el $storedCurso,guardo los cursos x po id para acceder despues a ellos por su id
            }
            //chequeo si el curso que estoy agregando ahora ($id) , se encuentra entre todos los ursos que tengo en la coleccion
            if (array_key_exists($id,$this->cursos)){
                $storedCurso=$this->cursos[$id];//esta linea sobreescribe el $storedCurso,guardo los cursos x po id para acceder despues a ellos por su id
            }
        }
        
        if ($opciones[0]['alumno']==0){
            $storedCurso['alumno'][$opciones[0]['alumno']['id']]=$opciones[0]['representante'];
        }else {
            $storedCurso['alumno'][$opciones[0]['alumno']['id']]=$opciones[0]['alumno'];//guardar los alumnos por su id    
        }  
        

        $this->representante=$opciones[0]['representante'];
        $storedCurso['qty']++;//incrementar la cantidad d cursos

        //costo de la matricula si se selecciona
        if (($opciones[0]['set_matricula'])=='on'){
            $storedCurso['matricula']=$curso->program->matricula;
        }

        //descuento a empleados
        if (($opciones[0]['desc_emp'])=='true'){
            $this->desc_empleado=$opciones[0]['desc_emp'];
        }

        //descuento para familiares
        if ( $opciones[0]['tipo_desc']=='familiar' ){
//            $desc=0.1;
            $this->tipo_desc=$opciones[0]['tipo_desc'];
        }

        //descuento para inscipcines multiples
        if ( $opciones[0]['tipo_desc']=='multiple') {
//            $desc=0.1;
            $this->tipo_desc=$opciones[0]['tipo_desc'];
        }


        $matricula=$storedCurso['matricula'];

        $storedCurso['precio']=$curso->mensualidad*$storedCurso['qty']; //itemCurso=curso->precio*cantidad

        $this->cursos[$id]=$storedCurso;//accedo al item sino exite en la coleccion guardo el primer $storedCurso
        
        $this->totalCursos++; //total de cursos en general en la coleccion

        $this->totalPrecio+= $curso->mensualidad + $matricula ;//precio total de la  coleccion, con descuentos


//        $descuento= ( $this->totalPrecio * ( $desc + $desc_empleado ) );
       
//        $this->descuento=$descuento;

    }

    public function restarUno($id) {

        $this->cursos[$id]['qty']--;
        $this->cursos[$id]['precio'] -= $this->cursos[$id]['curso']['mensualidad'];
        $this->totalCursos--;
        $this->totalPrecio -= $this->cursos[$id]['curso']['mensualidad'];
        if ($this->cursos[$id]['qty']<=0){
            unset($this->cursos[$id]);//destrulle la variable y todos su elementos para que no haya precios ni cantidades negativas
        }

    }

    public function restarTodos($id){

        $this->totalCursos -= $this->cursos[$id]['qty'];
        $this->totalPrecio -= $this->cursos[$id]['precio'];
        unset($this->cursos[$id]);
    }

}