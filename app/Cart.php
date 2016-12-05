<?php
/**
 * Esta clase se utiliza para guardar la cantidad de productos en la sesscion y no hereda de elocuent
 * es un clase normal.
 *
 * Almacena los items en el carrito  de lo que se desea comprar(cantidad, precios, etc)
 */

namespace App;



class Cart
{

    /**
     * Items -> Grupos del mismo producto, para agruparlos, inicialmente lo pongo vacio
     * Ejemplo: Items#1(tiene 3 Iphone5), Items#2(tiene 2 LG)
     */
    public $items=null; //grupos por productos del mismo tipo

    public $totalQty=0; //cantidad total de productos en el carrito

    public $totalPrice=0; //Precio total de la inscripcion

    public $discount=0; //Descuento total de la inscripcion
    
    

    //agregar al constructor xk hay k estar sobreescribiendo cada ves k se adiciona un producto
    public function __construct($oldCart)
    {
        if ($oldCart){
            $this->items=$oldCart->items;
            $this->totalQty=$oldCart->totalQty;
            $this->totalPrice=$oldCart->totalPrice;
            $this->discount=$oldCart->discount;
        }
    }

    public function add($item,$id,$opciones){ //$id=calendar_id=producto $item=curso completo
        
        //Creo un array de items, inicio en 0 xk se ira incrementando, almaceno el precio del curso y el curso k es
        $storedItem=['qty'=>0,'price'=>$item->mensualidad,'item'=>$item];
        //compruebo si tengo items en el carrito
        if ($this->items){
            //chequeo si el producto que estoy agregando ahora, identificado por $id, se encuentra entre todos los productos que tengo en el carrito
            if (array_key_exists($id,$this->items)){
                $storedItem=$this->items[$id];//esta linea sobreescribe el $storedItem anterior constantemente segun se agregen productos, al guardar los items por su id esto permite acceder despues a ellos por su id
            }
        }

        $storedItem['qty']++;//incrementar la cantidad

        //costo de la matricula si se selecciona
        if (($opciones[0]['matricula'])=='on'){
            $mat=$opciones[0]['program']->matricula;
        }else $mat=0;

        //descuento a empleados
        if (($opciones[0]['desc_emp'])=='true'){
            $desc_empleado=0.5; //50%
        }else $desc_empleado=0;

        
        //descuentos a aplicar segun la etapa
        if ( (($opciones[0]['desc_est'])=='VERANO') && ( $storedItem['qty']>=3)){
            //condiciones para verano 10% ins de mas de un representado inscrito o 10% un inscrito en una disciplina mas de 3 meses
            $descX3=0.1;
            
        }elseif (($opciones[0]['desc_est'])=='INVIERNO'){
            //condiciones para invierno ... Dewcuento del 10% para inscripciones en mas de 3 meses en el mismo curso

        }



        $precio=$mat+($item->mensualidad-($item->mensualidad*$desc_empleado));
        
        $storedItem['price']=$precio*$storedItem['qty']; //PT items=producto->precio*cantidad Ejj : 3Ihphone a $100=> 100*3=300
        $this->items[$id]=$storedItem;//aqui accedo a mi item sino exite en el carrito guardo el primer $storedItem
        $this->totalQty++;
        $this->totalPrice+=$precio;//precio total del carrito, toda la compra
        //        if ($storedItem['qty']>1){
//            $item->price=$item->price*(30/100);
//        }

    }

    public function reduceByOne($id) {

        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['mensualidad'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['mensualidad'];
        if ($this->items[$id]['qty']<=0){
            unset($this->items[$id]);//destrulle la variable y todos su elementos para que no haya precios ni cantidades negativas
        }

    }

    public function removeItem($id){

        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }

}