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

    public $descuento=0;

    public $tipo_desc=0;
   
    
    

    //agregar al constructor xk hay k estar sobreescribiendo cada ves k se adiciona un producto
    public function __construct($oldCurso)
    {
        if ($oldCurso){
            $this->cursos=$oldCurso->cursos;
            $this->totalCursos=$oldCurso->totalCursos;
            $this->totalPrecio=$oldCurso->totalPrecio;
            $this->descuento=$oldCurso->descuento;
            $this->tipo_desc=$oldCurso->tipo_desc;
        }
    }

    public function addCursos($curso,$id,$opciones){ //$id=calendar_id=producto $item=curso completo
        
        //Creo un array de cursos, inicio en 0 xk se ira incrementando, almaceno el precio del curso, el curso, las opciones
        $storedCurso=['qty'=>0,'precio'=>$curso->mensualidad,'curso'=>$curso];
        //compruebo si tengo cursos en la coleccion de cursos
        if ($this->cursos){
            //chequeo si el curso que estoy agregando ahora ($id) , se encuentra entre todos los ursos que tengo en la coleccion
            if (array_key_exists($id,$this->cursos)){
                $storedCurso=$this->cursos[$id];//esta linea sobreescribe el $storedCurso,guardo los cursos x po id para acceder despues a ellos por su id
            }
        }

        $storedCurso['qty']++;//incrementar la cantidad d cursos

        //costo de la matricula si se selecciona
        if (($opciones[0]['set_matricula'])=='on'){
            $mat=$curso->program->matricula;
        }else $mat=0;

        //descuento a empleados
        if (($opciones[0]['desc_emp'])=='true'){
            $desc_empleado=0.5; //50%
        }else $desc_empleado=0;

        //descuento para familiares
        if ( (($opciones[0]['tipo_desc'])=='familiar')  && $storedCurso['qty']>=2){
            $desc=0.1;
            $descuento_aplicado='Descuento Familiar';
        }

        //descuento para inscipcines multiples
        if ( (($opciones[0]['tipo_desc'])=='multiple')  && $storedCurso['qty']>=3){
            $desc=0.1;
            $descuento_aplicado='Descuento Multiples Inscripciones';
        }
        $desc=0.1;

        $valor=$mat+($curso->mensualidad);
        
        $storedCurso['precio']=$valor*$storedCurso['qty']; //itemCurso=curso->precio*cantidad

        $this->cursos[$id]=$storedCurso;//accedo al item sino exite en la coleccion guardo el primer $storedCurso
        $this->totalCursos++; //total de cursos en general en la coleccion
        $this->totalPrecio+=$valor - ( ($curso->mensualidad*$desc_empleado) - ($curso->mensualidad*$desc));//precio total de la  coleccion, con descuentos


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