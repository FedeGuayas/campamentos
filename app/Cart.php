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
    //price=total de la inscripcion sin decuentos, solo con matricula y mensualidad
    public $descuento=0;

    //agregar al constructor xk hay k estar sobreescribiendo cada ves k se adiciona un producto
    public function __construct($oldCart)
    {
        if ($oldCart){
            $this->items=$oldCart->items;
            $this->totalQty=$oldCart->totalQty;
            $this->totalPrice=$oldCart->totalPrice;
        }
    }

    public function add($item,$id){ //$id=calendar_id=producto $item=curso completo
        //Creo un array de items, inicio en 0 xk se ira incrementando, almaceno el precio del curso y el curso k es
        $storedItem=['qty'=>0,'price'=>$item->mensualidad,'item'=>$item];
        //compruebo si tengo items en el carrito
        if ($this->items){
            //chequeo si el producto que estoy agregando ahora, identificado por $id, se encuentra entre todos los productos que tengo en el carrito
            if (array_key_exists($id,$this->items)){
                $storedItem=$this->items[$id];//esta linea sobreescribe el $storedItem anterior constantemente segun se agregen productos
            }
        }
        $storedItem['qty']++;//incrementar la cantidad
        $storedItem['price']=$item->mensualidad*$storedItem['qty']; //precio total de los items=producto->precio*cantidad Ejj : 3Ihphone a $100=> 100*3=300
        $this->items[$id]=$storedItem;//aqui accedo a mi item sino exite en el carrito guardo el primer $storedItem
        $this->totalQty++;    //precio total del carrito, toda la compra
        $this->totalPrice+=$item->mensualidad;
        //        if ($storedItem['qty']>1){
//            $item->price=$item->price*(30/100);
//        }

    }

    public function reduceByOne($id) {

        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
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