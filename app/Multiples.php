<?php
/**
 * Esta clase se utiliza para guardar la cantidad de productos en la sesscion y no hereda de elocuent
 * es un clase normal.
 *
 * Almacena los items en el carrito  de lo que se desea comprar(cantidad, precios, etc), no calculo descuentos en esta clase
 */

namespace App;



class Multiples
{

    /**
     * Items -> Grupos del mismo producto, para agruparlos, inicialmente lo pongo vacio
     * Ejemplo: Items#1(tiene 3 Iphone5), Items#2(tiene 2 LG)
     */

    /** Estructura del carrito
    cursos:{
            4098 :{ agrupado por el id de curso(calendar_id) ej: 4098  ($storedCurso)
                    qty: 1
                    precio: 40
                    matricula: 0
                    curso: {
                            calendar: con toda su data con la relaciones a: dia, horario, program
                                }
                    alumno: {
                            11382: { agrupo por id de alumno(alumno_id) ej : 11382
                                     alumno: con toda su data y su relacion con persona
                                   }
                            cancelado_mensual: 40
                            matricula_mensual: 10
                            }
            }
            desc_empleado: "true"
            tipo_desc: "familiar"
            totalCursos: 1
            totalPrecio: 40
            totalMatricula: 10
            representante: {
                            representante
                            }

     **/

    public $cursos=null; //grupos por cursos del mismo tipo

    public $totalCursos=0; //cantidad total de grupos

    public $totalPrecio=0; //Precio total de la inscripcion (todos los cursos) no incluye matricula

    public $totalMatricula = 0; //Matricula total (todos los cursos)
    
    public $tipo_desc=null; 
    
    public $desc_empleado=null; // tiene prioridad sobre los demas descuentos de tipo_desc

    public $representante=null;
       
    
    //agregar al constructor xk hay k estar sobreescribiendo cada ves k se adiciona un producto
    public function __construct($oldCurso)
    {
        if ($oldCurso){
            $this->cursos=$oldCurso->cursos;
            $this->totalCursos=$oldCurso->totalCursos;
            $this->totalPrecio=$oldCurso->totalPrecio;
            $this->totalMatricula=$oldCurso->totalMatricula;
            $this->representante=$oldCurso->representante;
            $this->tipo_desc=$oldCurso->tipo_desc;
            $this->desc_empleado=$oldCurso->desc_empleado;
        }
    }

    public function addCursos($curso,$id,$opciones){ //agregar cursos a la coleccion (carrito)
        
        //Creo un array de cursos, inicio en 0 xk se ira incrementando, almaceno el precio del curso, el curso, precio de matricula y el alumno
        //$storedCurso = cursos[calendar_id]
        $storedCurso=['qty'=>0,'precio'=>0,'curso'=>$curso, 'matricula'=>0, 'alumno'=>[]];

        //si tengo cursos en el carrito
        if ($this->cursos){
            //permitir inscripciones multiples para solo un representante y evitar que se cambie el representante
            if ($this->representante['id']!=$opciones[0]['representante']['id']){
                return redirect()->back();
            }
            //si existe el alumno_id ya tiene una inscripcion almacenada en el arreglo $toredCurso,
            if (array_key_exists($opciones[0]['alumno']['id'],$storedCurso['alumno'])){
                //lo almaceno entonces en la coleccion ya existente
                $storedCurso['alumno']=$storedCurso['alumno'][$opciones[0]['alumno']['id']];
            }
            //si el curso que estoy agregando ($id) , se encuentra entre todos los cursos que tengo en la coleccion
            if (array_key_exists($id,$this->cursos)){
                //guardo los cursos x su id para acceder despues a ellos por su id
                $storedCurso=$this->cursos[$id];
            }
        }
//        else { //es el primer curso agregado
            //Es el primer curso, guardo los alumnos por su id
           $storedCurso['alumno'][ $opciones[0]['alumno']['id'] ]=$opciones[0]['alumno'];
//        }

        //lo que cancela de pago mensual por alumno por el curso actual cursos:curso_id:alumno:cancelado_mensual=$20.00
        $storedCurso['alumno'][ $opciones[0]['alumno']['id'] ] ['cancelado_mensual'] = $opciones[0]['cancelado_mensual'];

        //incrementar la cantidad d cursos
        $storedCurso['qty']++;

        //costo de la matricula si se selecciona
        if (($opciones[0]['set_matricula'])=='on' || ($opciones[0]['paga_matricula_river'])=='true'){
            //total pagado en matriculas para un curso , varios alumnos pueden estar en el mismo curso
            $storedCurso['matricula'] += $curso->program->matricula;
            // total de todas matriculas pagadas en todos los cursos
            $this->totalMatricula += $curso->program->matricula;
            //matricula por alumno solo en ese curso
            $storedCurso['alumno'][ $opciones[0]['alumno']['id'] ] ['matricula_mensual'] = $curso->program->matricula;
        }else {
            $storedCurso['alumno'][ $opciones[0]['alumno']['id'] ] ['matricula_mensual'] = 0;
        }

        //si se aplicara o no descuento a empleados, esto quedo para pruebas xk no implemente los desceuntos dentro de esta clase
        if (($opciones[0]['desc_emp'])=='true'){
            $this->desc_empleado=$opciones[0]['desc_emp']; 
        }

        if ( $opciones[0]['tipo_desc'] != '' ){
            $this->tipo_desc=$opciones[0]['tipo_desc'];
        }

        //descuento para familiares
//        if ( $opciones[0]['tipo_desc']=='familiar' ){
//            $desc=0.1;
//            $this->tipo_desc=$opciones[0]['tipo_desc'];
//        }

        //descuento para primos 5%
//        if ( $opciones[0]['tipo_desc']=='primo' ){
//            $desc=0.05;
//            $this->tipo_desc=$opciones[0]['tipo_desc'];
//        }

        //descuento para inscripciones multiples
//        if ( $opciones[0]['tipo_desc']=='multiple') {
//            $desc=0.1;
//            $this->tipo_desc=$opciones[0]['tipo_desc'];
//        }

//        $storedCurso['cancelado_mensual']+=$opciones[0]['cancelado_mensual'];
        $storedCurso['precio']=($curso->mensualidad*$storedCurso['qty']); //itemCurso=curso->precio*cantidad

        // Representante
        $this->representante=$opciones[0]['representante'];

        $this->cursos[$id]=$storedCurso;//accedo al item sino exite en la coleccion guardo el primer $storedCurso
        
        $this->totalCursos++; //total de cursos en general en la coleccion

        $this->totalPrecio+= $curso->mensualidad;//precio total de las mensualidades sin descuentos 
        
    }

    // deshabilitado por problemas al restar 1 cuando hay mas de 1 alumno en un curso
    public function restarUno($id) {

        $this->cursos[$id]['qty']--; //decremento la cantidad
        $this->cursos[$id]['precio'] -= $this->cursos[$id]['curso']['mensualidad']; //resto el precio de la mensualidad para los mismos items
        $this->totalCursos--; //decremento la cantidad de cursos en el carrito
        $this->totalPrecio -= $this->cursos[$id]['curso']['mensualidad']; //resto el precio del general
//        $this->cursos[$id]['alumno']['cancelado_mensual'] -= $this->cursos[$id]['curso']['mensualidad'];

        if ($this->cursos[$id]['matricula']>0){ //sino quedan cursos
            $this->cursos[$id]['matricula'] -= $this->cursos[$id]['curso']->program['matricula'];
            $this->totalMatricula -= $this->cursos[$id]['curso']->program['matricula'];
        }

        if ($this->cursos[$id]['qty']<=0){ //sino quedan cursos
            unset($this->cursos[$id]);//destrullo la variable y todos su elementos para que no haya precios ni cantidades negativas
        }

    }

    public function restarTodos($id){

        $this->totalCursos -= $this->cursos[$id]['qty'];
        $this->totalPrecio -= $this->cursos[$id]['precio'];
        $this->totalMatricula -= $this->cursos[$id]['matricula'];
        unset($this->cursos[$id]);
    }

}