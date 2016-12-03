    @if (Session::has('cart'))
    <div class="row">
        <div class="col l10 offset-l1 col s6 col m6 offset-m3 offset-s3">
            <ul class="list-group">
                @foreach($products as $product)
                    <li class="list-group-item">
                        <span class="badge red white-text">{{$product['qty']}}</span>
                        <span class="truncate flow-text">ProgramID aaaaaaaaa{{$product['item']['program_id']}} </span>
                        <h5><span class="label label-success">$ {{number_format($product['price'],2,'.',' ')}}</span></h5>

                        <div class="btn-group">
                            <button type="button" data-toggle="dropdown" class="btn btn-xs waves-effect waves-light dropdown-toggle" >Acción <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('product.reduceByOne',['id'=>$product['item']['id']])}}"><i class="fa fa-trash-o red-text"></i> Quitar 1</a></li>
                                <li class="divider"></li>
                                <li><a href="{{route('product.remove',['id'=>$product['item']['id']])}}">Quitar todos</a></li>
                            </ul>
                        </div>
                    </li>

                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s2 offset-s2">
            <h5><span class="label label-primary">Total: ${{number_format($totalPrice,2,'.',' ')}}</span></h5>
        </div>
        <div class="col s2 offset-s3">
            <a href="!#" type="button" class="btn btn-lg waves-effect waves-light"><i class="fa fa-money" aria-hidden="true"></i> Pagar</a>
        </div>
    </div>

@else
    <div class="row">
        <div class="col s6 col m6 offset-m3 offset-s3">
            <h2>No hay productos en el carrito</h2>
        </div>
    </div>
@endif


