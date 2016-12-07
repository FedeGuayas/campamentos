@if (Session::has('curso'))
    <div class="row">
        <div class="col l10 offset-l1 col s6 col m6 offset-m3 offset-s3">
            <ul class="list-group">
                @foreach($cursos as $curso)
                    <li class="list-group-item">
                        <span class="badge red white-text">{{$curso['qty']}}</span>
                        <span class="truncate flow-text">{{$curso['curso']['program']['escenario']['escenario']}} /
                            {{$curso['curso']['program']['disciplina']['disciplina']}} /
                            {{$curso['curso']['program']['modulo']['modulo']}} /
                            $ {{ number_format($curso['curso']['mensualidad'],2,'.',' ')}}
                        </span>
                        <h5>Acumulado: <span class="label label-success">$ {{number_format($curso['precio'],2,'.',' ')}}</span>
                        </h5>

                        <div class="btn-group">
                            <button type="button" data-toggle="dropdown"
                                    class="btn btn-xs waves-effect waves-light dropdown-toggle">Acción <span
                                        class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('inscripciones.restarUno',['id'=>$curso['curso']['id']])}}"><i class="fa fa-trash-o red-text"></i> Quitar 1</a></li>
                                <li class="divider"></li>
                                <li><a href="{{route('inscripciones.restarTodo',['id'=>$curso['curso']['id']])}}">Quitar todos</a></li>
                            </ul>
                        </div>
                    </li>

                @endforeach
            </ul>
        </div>
    </div>
    <hr>
    <h5>Descuento: <span class="label label-warning"> $ {{ number_format($descuento,2,'.',' ')}}</span></h5>
{{--    <h5>Matricula: <span class="label label-warning"> $ {{ number_format($matri,2,'.',' ')}}</span></h5>--}}
    <h5>Conceptos:
        @if($tipo_desc=='familiar')
            Inscripción Familiar
        @endif
        @if($tipo_desc=='multiple')
            Inscripción multiples meses
        @endif
    </h5>



    <div class="row">
        <div class="col s2 offset-s2">
            <h5><span class="label label-primary">Total: ${{number_format($total,2,'.',' ')}}</span></h5>
        </div>
        <div class="col s2 offset-s3">
            <a href="{{route('inscripciones.multipleStore')}}" type="button" class="btn btn-lg waves-effect waves-light"><i class="fa fa-money" aria-hidden="true"></i> Pagar
            </a>
        </div>
    </div>


@else
    <div class="row">
        <div class="col s6 col m6 offset-m3 offset-s3">
            <h2>No hay Cursos en la coleccion</h2>
        </div>
    </div>
@endif


